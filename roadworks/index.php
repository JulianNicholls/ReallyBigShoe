
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
<?php if( $_SERVER['SERVER_NAME'] == 'localhost' ) : ?>  
  <title>RW Local</title>
<?php else : ?>
  <title>Highways Agency Roadworks Information - Updated 2013-08-17</title>
<?php endif; ?>
  <link rel="stylesheet" href="roadworks.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
  <script type="text/javascript" src="roadworks.js"></script>
</head>

<body>
  <header>
    <img src="images/RBSLogo2.png" alt="RBS Logo" />
    <h1>Roadworks Information</h1>
  </header>
  <div id="container">
    <div id="form-holder">
      <form id="select-form" action="roadwork-data.php" method="get">
        <fieldset><legend>Select or Search</legend>
          <label for="road">Road</label>
          <select id="road" name="road">
<?php
  require_once 'data_access.php';

  $roads = road_list();

  foreach( $roads as $road ) :
    echo '<option value="' . $road . '">' . "$road</option>\n";
  endforeach;
?>
          </select><br />
          <label for="location">Search Location</label>
          <input type="text" name="location" value="" id="location" placeholder="Location" />
        </fieldset>
      </form>
    </div>  <!-- form-holder -->

    <h2>Introduction</h2>
    <p>In 2011, the UK's
      <a href="http://www.dft.gov.uk" title="DfT Site">Department for Transport (DfT)</a>
      started to issue datasets for public use under the 
      <a href="http://www.nationalarchives.gov.uk/doc/open%2Dgovernment%2Dlicence/" title="Usage License">
        Open Government License. 
      </a>
    </p>

    <p>Presented here is the latest data on planned roadworks on the Highway Agency's roads,
     distilled from the data files on
     <a href="http://data.gov.uk/dataset/highways_agency_planned_roadworks" title="dataset">this page</a>. 
     You can find information presented by road number, or search by location.  
    </p>
    <p>These are the outstanding roadworks from the 11 Nov 2013 data on the site,
      covering roadworks up to the middle of 2014. 
      I will keep this page updated as new roadworks are posted on the DfT site, 
      which is currently happening fairly regularly.
    </p>
    <p>There are more information sets available, e.g. car parks and cycle routes, 
      that I plan to look at, so please keep coming back for more.    
    </p>
  
    <div id="roadworks-info">
      <?php echo road_data( 'A1' ); ?>
    </div><!-- #roadworks-info -->
  </div>
  
  <footer>
    <img src="images/RBSLogo2_small.png" alt="RBS Small Logo">
    <nav>
      <li><a href="http://reallybigshoe.co.uk/portfolio.html">Portfolio</a></li>
      <li><a href="http://twitter.com/ReallyBigShoeUK" target="_blank">Twitter</a></li>
      <li><a href="https://github.com/JulianNicholls" target="_blank">GitHub</a></li>
    </nav>
    <small>Originally created on a MAC with <a href="http://macromates.com/">TextMate</a>,
      <a href="http://www.mysql.com/">MySQL</a>,        
      <a href="http://www.perl.org/">Perl</a>, and 
      <a href="http://php.net">PHP</a></small>   
  </footer>  
</body>
</html>
