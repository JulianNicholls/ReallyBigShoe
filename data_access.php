<?php

    if( isset( $_GET['road'] ) )
    {
        echo road_data( $_GET['road'] );
    }
    elseif( isset( $_GET['location'] ) )
    {
        echo location_data( $_GET['location'] );
    }


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
    
    return $roads;
}


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


function db_connect()
{
    $conn = new mysqli( NULL, 'juliann1_rw', 'roadworks', 'juliann1_roadworks' );

    if( $conn->connect_error ) {
        die( "Connection Error: (" . $conn->connect_errno . ') ' . $conn->connect_error );
    }
    
    return $conn;
}

        
function format_road( $road )
{
    $search = array( "/$road->name /", '/SB/', '/NB/', '/jct/i', '/lenght/', '/hardshoulder/i' );
    $replace= array( '', 'Southbound', 'Northbound', 'Jct', 'length', 'hard shoulder' );
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
