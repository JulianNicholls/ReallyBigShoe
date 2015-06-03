#! env perl -w

use strict;
use warnings;

use DBI;
use XML::Rules;


my $parser = XML::Rules->new(
    stripspaces => 7,
    rules => {
        q(CarPark) => \&process_CarPark
#        description => \&process_description

    }
);

my $dbh = DBI->connect( 'DBI:mysql:juliann1_roadworks:host=localhost', 'root', 'root', { RaiseError => 1 } );
my $add = $dbh->prepare( q{INSERT INTO carparks (ref, name, location, address, postcode, notes, tel, url) VALUES(?,?,?,?,?,?,?,?)} );

my $filename = @ARGV ? $ARGV[0] : q(CarParkData_1.xml);

print qq{Loading $filename...\n};

$parser->parsefile( $filename );

print "\nDone\n";


sub process_CarPark
{
    my( $name, $attrs ) = @_;

    my $ref = $attrs->{'CarParkRef'}->{'_content'};

    $add->execute( 
        $ref, 
        $attrs->{'CarParkName'}->{'_content'}, 
        $attrs->{'Location'}->{'_content'},
        $attrs->{'Address'}->{'_content'},
        $attrs->{'Postcode'}->{'_content'},
        $attrs->{'Notes'}->{'_content'},
        $attrs->{'Telephone'}->{'_content'},
        $attrs->{'URL'}->{'_content'}

    );

    if( $ref % 100 == 0 ) {
        print "$ref...\n";
    }
    
#    print qq/$attrs->{'CarParkRef'}->{'_content'}, $attrs->{'CarParkName'}->{'_content'}, $attrs->{Location}->{'_content'}\n/;

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

