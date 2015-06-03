<?php
//---------------------------------------------------------------------------
// AJAX calls to return the data for a road or a location

    if( isset( $_GET['road'] ) )
    {
        echo road_data( $_GET['road'] );
    }
    elseif( isset( $_GET['location'] ) )
    {
        echo location_data( $_GET['location'] );
    }

    
//---------------------------------------------------------------------------
// Clear out all the roads from the database in preparation to replace them.

function empty_roads( $conn )      // Wouldn't that be a nice thing?
{
    return $conn->query( "DELETE FROM roadworks" );     // Nuclear option
}


//---------------------------------------------------------------------------
// Add a road's information

function add_road( $conn, $road )
{
    $location    = $conn->real_escape_String( $road->location );
    $description = $conn->real_escape_String( $road->description );
    
    $query_string = 'INSERT INTO roadworks ( name, location, mapref, start, end, delay, description )' .
                    "VALUES( '$road->road', '$location', " .
                    "'$road->centre_easting $road->centre_northing', " .
                    "'$road->start_date', '$road->end_date', '$road->delay', " .
                    "'$description')";

//    echo $query_string;

    return $conn->query( $query_string );
}

//---------------------------------------------------------------------------
// Return a list of roads that have outstanding roadworks, in name order.

function road_list()
{
    $conn = db_connect();
    
    $roads = array();
    
    if( ($result = $conn->query( "SELECT DISTINCT name FROM roadworks WHERE end >= NOW() ORDER BY name ASC" )) !== FALSE )
    {
        while( $row = $result->fetch_row() )
            $roads[] = $row[0];
          
        $result->close();
    }
    
    natsort( $roads );      // Change ordering to make sense
    
    return $roads;
}


//---------------------------------------------------------------------------
// Return all the roadworks data for a road, formatted as HTML articles.
// This may be one or more records.

function road_data( $road )
{
    $conn   = db_connect();
    $data   = '';
    
    if( ($result = $conn->query( "SELECT * FROM roadworks WHERE name = '$road'" )) !== FALSE )
    {
        while( $cur = $result->fetch_object() )
        {
            $data .= format_road( $cur );
        }
      
        $result->close();
    }
    
    return $data;
}


//---------------------------------------------------------------------------
// Return all the roadworks that mention a location as HTML articles.
// Potentially, there will be no return data.

function location_data( $location )
{
    $conn = db_connect();
    $data = '';
    
    if( ($result = $conn->query( "SELECT * FROM roadworks WHERE location LIKE '%$location%'")) !== FALSE )
    {
        if( $result->num_rows ) 
        {
            while( $cur = $result->fetch_object() )
            {
                $data .= format_road( $cur );
            }
        }
        else
            $data = "<article>No Roadworks found for that location</article>";
            
        $result->close();
    }
    
    return $data;
}


//---------------------------------------------------------------------------
// Establish a DB connection.

function db_connect()
{
    $conn = new mysqli( NULL, 'juliann1_rw', 'roadworks', 'juliann1_roadworks' );

    if( $conn->connect_error ) {
        die( "Connection Error: (" . $conn->connect_errno . ') ' . $conn->connect_error );
    }
    
    return $conn;
}

  
//---------------------------------------------------------------------------
// Format a road as an HTML article.
// Certain words are corrected or extended.

function format_road( $road )
{
    $search = array( "/$road->name /", '/SB/', '/NB/', '/jct/i', '/jnc/i', '/lenght/', '/hardshoulder/' );
    $replace= array( '', 'Southbound', 'Northbound', 'Junction', 'Junction', 'length', 'hard shoulder' );
    $text   = '';
    $class  = $road->name[0] == 'A' ? 'a-road' : 'm-way';

    $sdate  = new DateTime( $road->start );
    $edate  = new DateTime( $road->end );
    $now    = new DateTime( 'now' );
    
    if( $edate >= $now ) {
        $location = preg_replace( $search, $replace, $road->location );
        $desc     = preg_replace( $search, $replace, $road->description );
  
        $text  = "<article class=\"$class\">\n <h1>$road->name</h1> ";
        $text .= "$location ($road->mapref)<br />\n";
        $text .= 'From ' . $sdate->format( 'd-m-Y' ) . ' to ' . $edate->format( 'd-m-Y') . "<br />\n";
        $text .= "Delays $road->delay<br />\n";
        $text .= "<p class=\"desc\">$desc</p>";
        $text .= "\n</article>\n";
    }

    return $text;
}
