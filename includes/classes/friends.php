<?php

class Friends
{

  public function __construct($username, $booziest)
  {
    $this->_pals = $this->render_pals($username, $booziest->_userPals);

    // Assemble the pieces and echo HTML.
    $this->render($username, $this->_pals);
  }

  /**
   * Return HTML for the User Pals box.
   *
   * @param $username
   *   Object. The queried Untappd user's username, from the GET/POST.
   * @param $userPals
   *    User friend object for the queried user.
   *
   * @return $output
   *    String of HTML.
   */
  protected function render_pals($username, $userPals)
  {
    if ($userPals->response->count == 0) {
      return;
    }

    $output  = '<div id="user-pals" class="clearfix hidden">';
    $output .= '<h4>Friends</h4>';
    $output .= '<p>Click on a friend to compare your booziest beers.</p>';

    $output .= '<ul class="small-block-grid-2 medium-block-grid-3 large-block-grid-4">';

    foreach ($userPals->response->items as $pal) {
      $compare_link = '/?compare=' . $username . '+' . $pal->user->user_name;
      // @todo replace the default avatar with the logo
      $output .= '<li><div class="user-photo" style="background-image: url(' . $pal->user->user_avatar .')"><a href="'. $compare_link .'"></a></div>';
      $output .= '<a class="username" href="'. $compare_link .'">' . $pal->user->user_name . '</a></li>';
    }

    $output .= '</ul>';
    $output .= '</div>';

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
  protected function render($userPals)
  {

    $output = '';
    if (!empty($userPals)) {
      $output .= '<a id="show-pals" class="button small radius right">Compare to friends</a>';
      $output .= $userPals;
    }

    echo $output;
  }


}
