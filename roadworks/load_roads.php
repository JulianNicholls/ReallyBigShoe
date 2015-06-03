<?php
    require_once "data_access.php";
    
    $raw_xml   = file_get_contents( "ha-roadworks_2013_04_15.xml" );
    $road_data = simplexml_load_string( $raw_xml );
    $conn      = db_connect();
    
    $cur = $road_data->ha_planned_works[0];
    
    print( "{$cur->road}: $cur->start_date to $cur->end_date\n" );
    print( "Location: $cur->location ($cur->centre_easting $cur->centre_northing)\n" );
    print( "$cur->description\n" );
    print( "Delay: $cur->expected_delay\n" );
    
    if( !empty_roads( $conn ) )
        die( "Error: (" . $conn->errno . ') ' . $conn->error );

    foreach( $road_data->ha_planned_works as $cur )
    {
        print( "{$cur->road}: $cur->location\n" );
        
        if( !add_road( $conn, $cur ) )
            die( "Error: (" . $conn->errno . ') ' . $conn->error );
    }
        
//    print_r( $road_data );
    
// Name
// Location / Mapref
// Start Date
// End Date
// Delay
// Description
