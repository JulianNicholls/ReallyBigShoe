#! env perl -w

use strict;
use warnings;

use DBI;
use XML::Rules;


my $parser = XML::Rules->new(
    stripspaces => 7,
    rules => {
        ha_planned_works => \&process_planned_works
#        description => \&process_description

    }
);

my $dbh = DBI->connect( 'DBI:mysql:juliann1_roadworks:host=localhost', 'root', 'root', { RaiseError => 1 } );
my $add = $dbh->prepare( q{INSERT INTO roadworks (name, location, mapref, start, end, delay, description) VALUES(?,?,?,?,?,?,?)} );

my $filename = @ARGV ? $ARGV[0] : 'ha-roadworks_2011_11_21.xml';

print qq{Loading $filename ... };

$parser->parsefile( $filename );

sub process_planned_works
{
    my( $name, $attrs ) = @_;

    $add->execute(
        $attrs->{'road'}->{'_content'},  
        $attrs->{'location'}->{'_content'}, 
        $attrs->{'centre_easting'}->{'_content'} . ' ' . $attrs->{'centre_northing'}->{'_content'},
        $attrs->{'start_date'}->{'_content'}, $attrs->{'end_date'}->{'_content'},
        $attrs->{'expected_delay'}->{'_content'},
        $attrs->{'description'}->{'_content'}
    );

    print qq/( '$attrs->{'road'}->{'_content'}', '$attrs->{'location'}->{'_content'}', '$attrs->{'centre_easting'}->{'_content'} $attrs->{'centre_northing'}->{'_content'}', '$attrs->{'start_date'}->{'_content'}', '$attrs->{'end_date'}->{'_content'}', '$attrs->{'expected_delay'}->{'_content'}', '$attrs->{'description'}->{'_content'}'),\n/;
}


sub wordwrap       # String, Line Length
{
    my( $str, $width ) = @_;

    my $pos     = 0;
    my $strlen  = length $str;

    while( ($pos + $width) < $strlen ) {
        $pos += $width;
        while( substr( $str, $pos, 1 ) ne q{ } ) {
            --$pos;
        }

        substr( $str, $pos, 1 ) = "\n";
    }

    return $str;
}

