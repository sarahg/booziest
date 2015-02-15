<?php
/**
 * @file app.php
 */

include('keys.inc');

class Untapper
{

  private $userPals;
  private $beers;
  private $table;

  public function __construct($username)
  {
    // Given a username, look up their user's friend info and beers.
    $response = self::fetch_untappd_info($username);
    $this->_userPals = $response['userPals'];
    $this->_beers = $response['beers'];

    // If there are homies, show homies.
    if (!empty($this->_userPals)) {
      $this->_pals = $this->render_pals($this->_userPals);
    }

    // If they've got beers, show em in a table.
    if (!empty($this->_beers)) {
      $this->_table = $this->render_table($this->_beers);
    }

    // Assemble the pieces and echo HTML.
    $this->render($username, $this->_pals, $this->_table);
  }


  /**
   * Format the list of beers from Untappd.
   *
   * @param $username
   *    An untappd username
   *
   * @return $beers
   *    Array of the user's beers, ordered by ABV.
   */
  public function format_beers($beers)
  {
    if (empty($beers->response->beers->items)) {
      return;
    }

    foreach ($beers->response->beers->items as $beer) {
      $filteredBeers[] = array(
        'brewery' => $beer->brewery->brewery_name,
        'name' => $beer->beer->beer_name,
        'abv' => $beer->beer->beer_abv,
        'style' => $beer->beer->beer_style,
        'rating' => $beer->rating_score,
        'link' => $beer->brewery->contact->url,
        'logo' => $beer->brewery->brewery_label,
        'state' => $beer->brewery->location->brewery_state
      );
    }

    // Sort by ABV, high to low.
    usort($filteredBeers, function($a, $b) {
      return $b['abv'] > $a['abv'] ? 1 : -1;
    });

    return $filteredBeers;
  }


  /**
   * Retrieve a list of beers from Untappd.
   *
   * @param $username
   *    An untappd username
   *
   * @return $beers
   *    Array of the user's beers, sorted by ABV.
   */
  protected function fetch_untappd_info($username)
  {
    include('UntappdPHP/lib/untappdPHP.php');
    $ut = new UntappdPHP(CLIENT_ID, CLIENT_SECRET, BASE_URL);

    $beers = $ut->get('/user/beers/' . $username . '?limit=50');
    $userPals = $ut->get('/user/friends/' . $username);

    $info = array('beers' => $beers, 'userPals' => $userPals);

    // @todo return different error if API limit hit (see header)
    // or maybe could it email me? that'd be slick
    /*if ($response['beers']->meta->code !== 200) {
      return;
    }*/

    return $info;
  }


  /**
   * Return HTML for the table.
   *
   * @param $beers
   *    List of beers from the API call.
   *
   * @return $output
   *    String of HTML.
   */
  protected function render_table($beers)
  {
    $filteredBeers = self::format_beers($beers);
    if (empty($filteredBeers)) {
      return;
    }

    $table_headers = $output = $icon = '';

    $columns = array(
      '' => '',
      'Brewery' => 'string',
      'Name' => 'string',
      'State' => 'string',
      'ABV' => 'float',
      'Style' => 'string',
      'Rating' => 'float'
    );
    foreach ($columns as $name => $dataType) {
      $classes = strtolower($name);
      if ($name == 'ABV') {
        $classes .= ' sorting-desc';
        $icon = '<i class="fa fa-sort-desc"></i>';
      }
      if (empty($name)) {
        $classes .= 'image';
      }
      $table_headers .= '<th class="'. $classes . '" data-sort="'. $dataType .'"><a href="#">'. $name .'</a>'. $icon .'</th>';
    }

    $output .= '<p class="clearfix">Showing most recent '. count($filteredBeers) .' beers.';
    // $output .= '<a href="#show-100">Show 100</a>./p>'; // @todo hookup "show 100"
    $output .= '<table id="beer-results">';
    $output .= '<thead>'. $table_headers .'</thead><tbody>';
    foreach ($filteredBeers as $beer) {
      $output .= '<tr>';
      $output .= '<td class="image"><a href="'. $beer['link'] .'"><img height="50" width="50" src="'. $beer['logo'] .'"></a></td>';
      $output .= '<td class="brewery"><a href="'. $beer['link'] .'">'. $beer['brewery'] .'</a></td>';
      $output .= '<td class="name">' . $beer['name'] . '</td>';
      $output .= '<td class="state">' . $beer['state'] . '</td>';
      $output .= '<td class="abv" data-sort-value="'. $beer['abv'] .'">' . $beer['abv'] . '%</td>';
      $output .= '<td class="style">' . $beer['style'] . '</td>';
      $output .= '<td class="rating">' . $beer['rating'] . '</td>';
      $output .= '</tr>';
    }
    $output .= '</tbody></table>';

    return $output;
  }


  /**
   * Return HTML for the User Pals box.
   *
   * @param $userPals
   *    User friend object for the queried user.
   *
   * @return $output
   *    String of HTML.
   */
  protected function render_pals($userPals)
  {
    if ($userPals->response->count == 0) {
      return;
    }
    $output  = '<div id="user-pals" class="clearfix hidden">';
    $output .= '<h4>Friends</h4>';
    $output .= '<p>Click on a friend to compare your average ABV.</p>';

    foreach ($userPals->response->items as $pal) {
      $output .= '<div class="user-photo" style="background-image: url(' . $pal->user->user_avatar .')"><a href="#">' . $pal->user->user_name . '</a></div>';
    }
    $output .= '</div>';

    // @todo clicking on the friend name shows a page comparing your average ABV, or something?

    return $output;
  }


  /**
   * Pull together all the components and echo the output.
   *
   * @param $user
   *   Object. The queried Untappd user.
   * @param $table
   *   String of HTML for the main results table.
   *
   * @return @void
   */
  protected function render($username, $userPals, $table)
  {

    $output = '';

    if (!empty($table)) {

      $output .= '<h3 class="user left">' . $username . '\'s' . ' booziest beers' . '</h3>';

      if (!empty($userPals)) {
        $output .= '<a id="show-pals" class="button small radius right">Compare to palz</a>';
        $output .= $userPals;
      }

      $output .= $table;

    }
    else {
      $output .= '<h3 class="no-user">No beers found.</h3>';
      $output .= '<ul>';
      $output .= '<li><a href="https://www.google.com/maps/search/bars+near+current+location">Go drinking</a>.</li>';
      $output .= '<li><a href="/">Search again</a>.</li>';
      $output .= '</ul>';
    }

    echo $output;
  }

}

// @todo allow $_GET for sharing links to result page
$username = $_POST['username'];
new Untapper($username);

?>
