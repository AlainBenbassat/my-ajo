<?php

class MyAjo_Verjaardagen {
  public static function get() {
    $html = '';
    $currentMonthNumber = '';

    $contacts = \Civi\Api4\Contact::get(FALSE)
      ->addSelect('birth_date', 'next_birthday', 'first_name', 'middle_name', 'last_name', 'Extra_orkestlid_info.Hoofdinstrument')
      ->addJoin('GroupContact AS group_contact', 'INNER', ['group_contact.contact_id', '=', 'id'])
      ->addWhere('birth_date', 'IS NOT NULL')
      ->addWhere('next_birthday', '<=', 90)
      ->addWhere('group_contact.group_id', '=', 6)
      ->addWhere('group_contact.status', '=', 'Added')
      ->addOrderBy('next_birthday', 'ASC')
      ->execute();

    foreach ($contacts as $contact) {
      $birthDayMonthNumber = substr($contact['birth_date'], 5, 2);
      if ($birthDayMonthNumber != $currentMonthNumber) {
        if ($html) {
          $html .= '</table>';
        }

        $html .= '<h2 style="margin-top: 30px;">In de maand ' . self::getMonthName($birthDayMonthNumber) . '</h2>';
        $html .= '<table style="width: 100%; max-width: 600px;">';

        $currentMonthNumber = $birthDayMonthNumber;
      }

      $html .= '<tr>';
      $html .= '<td>' . $contact['first_name'] . '</td>';
      $html .= '<td>' . $contact['middle_name'] . ' ' . $contact['last_name'] . '</td>';
      $html .= '<td>' . substr($contact['birth_date'], 8, 2) . ' ' . self::getMonthName($birthDayMonthNumber) . '</td>';
      $html .= '<td>' . date('Y') - (int)substr($contact['birth_date'], 0, 4) . ' jaar</td>';
      $html .= '<td>' . strtolower($contact['Extra_orkestlid_info.Hoofdinstrument']) . '</td>';
      $html .= '</tr>';
    }

    if ($html) {
      $html .= '</table>';
    }

    return $html;
  }

  private static function getMonthName($monthNumber) {
    $months = [
      '01' => 'januari',
      '02' => 'februari',
      '03' => 'maart',
      '04' => 'april',
      '05' => 'mei',
      '06' => 'juni',
      '07' => 'juli',
      '08' => 'augustus',
      '09' => 'september',
      '10' => 'oktober',
      '11' => 'november',
      '12' => 'december',
    ];

    return $months[$monthNumber];
  }

}