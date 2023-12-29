<?php

class My_Ajo_Smoelenboek {

  public static function get() {
    return
      self::getEersteViool()
      . self::getTweedeViool()
      . self::getAltViool()
      . self::getCelloContrabas()
      . self::getHoutblazers()
      . self::getKoperblazers()
      . self::getSlagwerkHarp();
  }

  private static function getEersteViool() {
    return
      self::formatSectionTitle('Eerste viool')
      . self::getOrkestGroepsLeden(1);
  }

  private static function getTweedeViool() {
    return
      self::formatSectionTitle('Tweede viool')
      . self::getOrkestGroepsLeden(2);
  }

  private static function getAltViool() {
    return
      self::formatSectionTitle('Altviool')
      . self::getOrkestGroepsLeden(3);
  }

  private static function getCelloContrabas() {
    return
      self::formatSectionTitle('Cello / Contrabas')
      . self::getOrkestGroepsLeden(4);
  }

  private static function getHoutblazers() {
    return
      self::formatSectionTitle('Houtblazers')
      . self::getOrkestGroepsLeden(5);
  }

  private static function getKoperblazers() {
    return
      self::formatSectionTitle('Koperblazers')
      . self::getOrkestGroepsLeden(6);
  }

  private static function getSlagwerkHarp() {
    return
      self::formatSectionTitle('Slagwerk &amp; Harp')
      . self::getOrkestGroepsLeden(9);
  }

  private static function formatSectionTitle($title) {
    return "<h3>$title</h3>";
  }

  private static function getOrkestGroepsLeden($civiIdOrkestGroep) {
    $huidigeOrkestLedenGroupId = 6;

    $contacts = \Civi\Api4\Contact::get(FALSE)
      ->addSelect('first_name', 'last_name', 'image_URL')
      ->addJoin('GroupContact AS group_contact', 'INNER', ['id', '=', 'group_contact.contact_id'], ['group_contact.status', '=', "'Added'"], ['group_contact.group_id', '=', $huidigeOrkestLedenGroupId])
      ->addWhere('Extra_orkestlid_info.Orkestgrplst', '=', $civiIdOrkestGroep)
      ->addOrderBy('sort_name', 'ASC')
      ->execute();

    foreach ($contacts as $contact) {
      $html .= '<div class="ajo_tile">';
      $html .= '<figure class="ajo_tile_figure">';

      if ($contact['image_URL']) {
        $html .= '<img src="' . $contact['image_URL'] . '" class="ajo_tile_picture">';
      }
      else {
        $html .= '<img src="' . site_url() . '/wp-content/uploads/2020/09/ajo-logo.png" class="ajo_tile_dummy_picture">';
      }

      $html .= '</figure>';

      $html .= '<div>';
      $html .= '<span class="ajo_tile_first_name">' . $contact['first_name'] . '</span><br>';
      $html .= '<span class="ajo_tile_last_name">' . $contact['last_name'] . '</span><br>';

      $urlToPersonDetails = site_url() . '/smoelenboek/smoelenboek-details/?q=civicrm%2Fprofile%2Fedit&reset=1&id=' . $contact['id'];
      $html .= '<a href="' . $urlToPersonDetails . '"><i class="ajo_tile_link"></i></a>'; //fa-link <i class="fa-solid fa-cloud-bolt"></i>
      $html .= '</div>';


      $html .= '</div>';
    }

    $html .= '<div class="ajo_clearfix"></div>';

    return $html;
  }
}