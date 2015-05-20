<?php

class User
{


  private $userPals;
  private $beers;
  private $table;

  public function __construct($username)
  {
    include( __DIR__.'/../../includes/keys.inc');

    // Given a username, look up their user's friend info and beers.
    $response = self::fetch_untappd_info($username);
    $this->_userPals = $response['userPals'];
    $this->_beers = $response['beers'];

    // If they've got beers, show em in a table.
    if (!empty($this->_beers)) {
      $this->_table = $this->render_table($username, $this->_beers);
    }

    // Assemble the pieces and echo HTML.
    $this->render($username, $this->_table);
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
    include( __DIR__.'/../../vendor/UntappdPHP/lib/untappdPHP.php');
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
   * @param $username
   *    An untappd username
   * @param $beers
   *    List of beers from the API call.
   *
   * @return $output
   *    String of HTML.
   */
  protected function render_table($username, $beers)
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

    $output .= '<h5 class="clearfix">Showing '. $username .'\'s most recent '. count($filteredBeers) .' beers.</h5>';
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
   * Pull together all the components and echo the output.
   *
   * @param $username
   *   Object. The queried Untappd user's username, from the GET/POST.
   * @param $table
   *   String of HTML for the main results table.
   *
   * @return @void
   */
  protected function render($username, $table)
  {

    $output = '';

    if (!empty($table)) {

      $output .= '<h3 class="user left">' . $username . '\'s' . ' booziest beers' . '</h3>';
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
