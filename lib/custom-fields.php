<?php

if(function_exists("register_field_group"))
{

  register_field_group(array (
    'id' => 'acf_post-karta-opis-karty',
    'title' => 'Post Karta => opis karty',
    'fields' => array (
      array (
        'key' => 'field_HeZa58dpr',
        'label' => 'Ilość i cena',
        'name' => 'tab_2',
        'type' => 'tab',
        ),
      array (
        'key' => 'field_56606fee5ca20',
        'label' => 'Ilość',
        'name' => 'ilosc',
        'type' => 'number',
        'default_value' => 1,
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => '',
        'max' => '',
        'step' => '',
        ),
      array (
        'key' => 'field_56825fd051b67',
        'label' => 'Sprzedane',
        'name' => 'sprzedane',
        'type' => 'number',
        'default_value' => 0,
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => '',
        'max' => '',
        'step' => 1,
        ),
      array (
        'key' => 'field_5964d04c485d3',
        'label' => 'Zarezerwowane',
        'name' => 'cards_reserved',
        'type' => 'number',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => 0,
        'max' => '',
        'step' => 1,
        ),
      array (
        'key' => 'field_5965caf6223f2',
        'label' => 'Zamrożona cena',
        'name' => 'price_frozen',
        'type' => 'true_false',
        'instructions' => 'Zaznacz, jeśli cena ma nie być aktualizowana przy uruchomieniu skryptu',
        'message' => '',
        'default_value' => 0,
        ),
      array (
        'key' => 'field_5660401366158',
        'label' => 'Cena',
        'name' => 'cena',
        'type' => 'number',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => '',
        'max' => '',
        'step' => '',
        ),
      array (
        'key' => 'field_566146ba6ca97',
        'label' => 'Discount',
        'name' => 'discount',
        'type' => 'number',
        'default_value' => 0,
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => 0,
        'max' => 1,
        'step' => '0.05',
        ),
      array (
        'key' => 'field_ocmkTld1a',
        'label' => 'Własność',
        'name' => 'tab_3',
        'type' => 'tab',
        ),
      array (
        'key' => 'field_56825fe251b68',
        'label' => 'Własność',
        'name' => 'własność',
        'type' => 'radio',
        'choices' => array (
          'Team' => 'Team',
          'Leszek' => 'Leszek',
          'Sławek' => 'Sławek',
          ),
        'other_choice' => 1,
        'save_other_choice' => 1,
        'default_value' => '',
        'layout' => 'horizontal',
        ),
      array (
        'key' => 'field_Jao3EJ7XTbAHbst6',
        'label' => 'Dane karty',
        'name' => 'tab_1',
        'type' => 'tab',
        ),
      array (
        'key' => 'field_5660462c53032',
        'label' => 'Edycja',
        'name' => 'edycja',
        'type' => 'radio',
        'required' => 1,
        'choices' => array (
          'Future Sight' => 'Future Sight',
          'Conflux' => 'Conflux',
          'Fifth Dawn' => 'Fifth Dawn',
          'Modern Masters' => 'Modern Masters',
          'Nemesis' => 'Nemesis',
          'Weatherlight' => 'Weatherlight',
          'Urza\'s Saga' => 'Urza\'s Saga',
          'Mirrodin Besieged' => 'Mirrodin Besieged',
          'Saviors of Kamigawa' => 'Saviors of Kamigawa',
          'Tenth Edition' => 'Tenth Edition',
          'Morningtide' => 'Morningtide',
          'Worldwake' => 'Worldwake',
          'Khans of Tarkir' => 'Khans of Tarkir',
          'Zendikar' => 'Zendikar',
          'Grand Prix Promos' => 'Grand Prix Promos',
          'Modern Masters 2015' => 'Modern Masters 2015',
          'Eighth Edition' => 'Eighth Edition',
          'Innistrad' => 'Innistrad',
          'Unglued' => 'Unglued',
          'Unhinged' => 'Unhinged',
          'Judge Rewards Promos' => 'Judge Rewards Promos',
          'Magic 2015' => 'Magic 2015',
          'Battle for Zendikar' => 'Battle for Zendikar',
          'Scars of Mirrodin' => 'Scars of Mirrodin',
          'Avacyn Restored' => 'Avacyn Restored',
          'Dragons of Tarkir' => 'Dragons of Tarkir',
          'Fate Reforged' => 'Fate Reforged',
          'Dark Ascension' => 'Dark Ascension',
          'Ravnica: City of Guilds' => 'Ravnica: City of Guilds',
          'Friday Night Magic Promos' => 'Friday Night Magic Promos',
          'Duel Decks: Zendikar vs. Eldrazi' => 'Duel Decks: Zendikar vs. Eldrazi',
          'Duel Decks: Elspeth vs. Tezzeret' => 'Duel Decks: Elspeth vs. Tezzeret',
          'Duel Decks: Ajani vs. Nicol Bolas' => 'Duel Decks: Ajani vs. Nicol Bolas',
          'Seventh Edition' => 'Seventh Edition',
          'Portal Second Age' => 'Portal Second Age',
          'Dissension' => 'Dissension',
          'Theros' => 'Theros',
          'Time Spiral' => 'Time Spiral',
          'Shadows over Innistrad' => 'Shadows over Innistrad',
          'Shadows over Innistrad: Promos' => 'Shadows over Innistrad: Promos',
          'Torment' => 'Torment',
          'Battle for Zendikar: Promos' => 'Battle for Zendikar: Promos',
          'Oath of the Gatewatch' => 'Oath of the Gatewatch',
          ),
        'other_choice' => 1,
        'save_other_choice' => 1,
        'default_value' => '',
        'layout' => 'horizontal',
        ),
      array (
        'key' => 'field_56603fdb66156',
        'label' => 'Stan',
        'name' => 'stan',
        'type' => 'radio',
        'required' => 1,
        'choices' => array (
          'nm' => 'Near Mint',
          'lp' => 'Lightly Played',
          'mp' => 'Moderately Played',
          'hp' => 'Heavily Played',
          ),
        'other_choice' => 0,
        'save_other_choice' => 0,
        'default_value' => 'nm',
        'layout' => 'horizontal',
        ),
      array (
        'key' => 'field_56603f7f66155',
        'label' => 'Język',
        'name' => 'jezyk',
        'type' => 'radio',
        'choices' => array (
          'eng' => 'Angielski',
          'de' => 'Niemiecki',
          'fr' => 'Francuski',
          'it' => 'Włoski',
          'sp' => 'Hiszpański',
          'ru' => 'Rosyjski',
          'jpn' => 'Japoński',
          'kor' => 'Koreański',
          'chi' => 'Chiński',
          ),
        'other_choice' => 1,
        'save_other_choice' => 1,
        'default_value' => 'eng',
        'layout' => 'horizontal',
        ),
      array (
        'key' => 'field_56603ffe66157',
        'label' => 'Uwagi',
        'name' => 'uwagi',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'html',
        'maxlength' => '',
        ),
      array (
        'key' => 'field_56605a3a84e7b',
        'label' => 'Rarity',
        'name' => 'rarity',
        'type' => 'radio',
        'choices' => array (
          1 => 'Mythic',
          2 => 'Rare',
          3 => 'Uncommon',
          4 => 'Common',
          5 => 'Inne',
          6 => 'Land',
          ),
        'other_choice' => 1,
        'save_other_choice' => 0,
        'default_value' => 5,
        'layout' => 'horizontal',
        ),
      array (
        'key' => 'field_56615f115e258',
        'label' => 'Foil?',
        'name' => 'foil',
        'type' => 'true_false',
        'message' => '',
        'default_value' => 0,
        ),
      array (
        'key' => 'field_SKokiPzCS0CTlqJFESF',
        'label' => 'Linki do MKM',
        'name' => 'tab_4',
        'type' => 'tab',
        ),
      array (
        'key' => 'field_56614804c4dd3',
        'label' => 'Link do obrazka',
        'name' => 'img_link',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'none',
        'maxlength' => '',
        ),
      array (
        'key' => 'field_56654bb040181',
        'label' => 'Link do karty',
        'name' => 'link_do_karty',
        'type' => 'text',
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'formatting' => 'html',
        'maxlength' => '',
        ),
      ),
'location' => array (
  array (
    array (
      'param' => 'post_type',
      'operator' => '==',
      'value' => 'post',
      'order_no' => 0,
      'group_no' => 0,
      ),
    ),
  ),
'options' => array (
  'position' => 'normal',
  'layout' => 'default',
  'hide_on_screen' => array (
    ),
  ),
'menu_order' => 0,
));
register_field_group(array (
  'id' => 'acf_post-koszyk-wybrane-karty',
  'title' => 'Post Koszyk => wybrane karty',
  'fields' => array (
    array (
      'key' => 'field_5964d130e216d',
      'label' => 'Karty',
      'name' => 'cards_list',
      'type' => 'repeater',
      'sub_fields' => array (
        array (
          'key' => 'field_5964d155e216e',
          'label' => 'Nazwa',
          'name' => 'card_name',
          'type' => 'post_object',
          'column_width' => '',
          'post_type' => array (
            0 => 'post',
            ),
          'taxonomy' => array (
            0 => 'all',
            ),
          'allow_null' => 0,
          'multiple' => 0,
          ),
        array (
          'key' => 'field_5964d176e216f',
          'label' => 'Cena',
          'name' => 'card_price',
          'type' => 'number',
          'column_width' => '',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'min' => 0,
          'max' => '',
          'step' => 1,
          ),
        array (
          'key' => 'field_5964d18ae2170',
          'label' => 'Ilość',
          'name' => 'card_amount',
          'type' => 'number',
          'column_width' => '',
          'default_value' => '',
          'placeholder' => '',
          'prepend' => '',
          'append' => '',
          'min' => 0,
          'max' => '',
          'step' => 1,
          ),
        ),
      'row_min' => 0,
      'row_limit' => '',
      'layout' => 'table',
      'button_label' => 'Add Row',
      ),
    array (
      'key' => 'field_5964d199e2171',
      'label' => 'Rabat',
      'name' => 'basket_discount',
      'type' => 'number',
      'column_width' => '',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => '',
      'step' => '0.1',
      ),
    array (
      'key' => 'field_5964d1b1e2172',
      'label' => 'Koszt wysyłki',
      'name' => 'basket_shipping_cost',
      'type' => 'number',
      'column_width' => '',
      'default_value' => 5,
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => '',
      'step' => 1,
      ),
    array (
      'key' => 'field_5964d1c8e2173',
      'label' => 'Wypłata Leszek',
      'name' => 'basket_leszek_sum',
      'type' => 'number',
      'column_width' => '',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => '',
      'max' => '',
      'step' => '',
      ),
    array (
      'key' => 'field_5964d1e1e2174',
      'label' => 'Wypłata Sławek',
      'name' => 'basket_slawek_sum',
      'type' => 'number',
      'column_width' => '',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => '',
      'max' => '',
      'step' => '',
      ),
    array (
      'key' => 'field_5964d1ebe2175',
      'label' => 'Wypłata total',
      'name' => 'basket_total_sum',
      'type' => 'number',
      'column_width' => '',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => '',
      'max' => '',
      'step' => '',
      ),
    array (
      'key' => 'field_5964d1f8e2176',
      'label' => 'Status koszyka',
      'name' => 'basket_status',
      'type' => 'select',
      'column_width' => '',
      'choices' => array (
        'preorder' => 'zamówienie wstępne',
        'for_shipping' => 'do wysłania',
        'shipped' => 'wysłane',
        'billed' => 'rozliczone',
        ),
      'default_value' => '',
      'allow_null' => 0,
      'multiple' => 0,
      ),
    ),
  'location' => array (
    array (
      array (
        'param' => 'post_type',
        'operator' => '==',
        'value' => 'basket',
        'order_no' => 0,
        'group_no' => 0,
        ),
      ),
    ),
  'options' => array (
    'position' => 'normal',
    'layout' => 'default',
    'hide_on_screen' => array (
      ),
    ),
  'menu_order' => 0,
  ));

register_field_group(array (
  'id' => 'acf_opcje-strony-zmienne-cron',
  'title' => 'Opcje Strony => zmienne cron',
  'fields' => array (
    array (
      'key' => 'field_9FRfUs5rbdnlwy0N',
      'label' => 'Rozliczenia',
      'name' => 'tab_1',
      'type' => 'tab',
      ),
    array (
      'key' => 'field_5964d09b4c4d5',
      'label' => 'Łącznie',
      'name' => 'billing_total',
      'type' => 'number',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => '',
      'step' => 1,
      ),
    array (
      'key' => 'field_5964d0ad4c4d6',
      'label' => 'Teamowe',
      'name' => 'billing_team',
      'type' => 'number',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => '',
      'step' => 1,
      ),
    array (
      'key' => 'field_5964d0bd4c4d7',
      'label' => 'Leszka',
      'name' => 'billing_leszek',
      'type' => 'number',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => '',
      'step' => 1,
      ),
    array (
      'key' => 'field_5964d0cd4c4d8',
      'label' => 'Sławka',
      'name' => 'billing_slawek',
      'type' => 'number',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => '',
      'step' => 1,
      ),
    array (
      'key' => 'field_6MvSMqKxMNazkZ',
      'label' => 'MKM API keys',
      'name' => 'tab_2',
      'type' => 'tab',
      ),
    array (
      'key' => 'field_5964d33145cf6',
      'label' => 'Token aplikacjii',
      'name' => 'app_token',
      'type' => 'text',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'formatting' => 'html',
      'maxlength' => '',
      ),
    array (
      'key' => 'field_5964d34445cf7',
      'label' => 'Secret aplikacji',
      'name' => 'app_secret',
      'type' => 'text',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'formatting' => 'html',
      'maxlength' => '',
      ),
    array (
      'key' => 'field_5964d35145cf8',
      'label' => 'Token dostępu',
      'name' => 'access_token',
      'type' => 'text',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'formatting' => 'html',
      'maxlength' => '',
      ),
    array (
      'key' => 'field_5964d35d45cf9',
      'label' => 'Secret dostępu',
      'name' => 'access_secret',
      'type' => 'text',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'formatting' => 'html',
      'maxlength' => '',
      ),
    array (
      'key' => 'field_4sKbSMA9',
      'label' => 'Szablon na forum',
      'name' => 'tab_3',
      'type' => 'tab',
      ),
    array (
      'key' => 'field_56650a7e9759e',
      'label' => 'Forum content',
      'name' => 'forum_content',
      'type' => 'textarea',
      'instructions' => 'Wpisz treść na forum, która ma się pojawić przed listą kart',
      'default_value' => '',
      'placeholder' => '',
      'maxlength' => '',
      'rows' => '',
      'formatting' => 'br',
      ),
    array (
      'key' => 'field_Lyo9p',
      'label' => 'Rabaty / stan karty',
      'name' => 'tab_4',
      'type' => 'tab',
      ),
    array (
      'key' => 'field_566502c74a0af',
      'label' => 'Discount lp',
      'name' => 'discount_lp',
      'type' => 'number',
      'default_value' => 0,
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => 1,
      'step' => '0.05',
      ),
    array (
      'key' => 'field_566502f44a0b0',
      'label' => 'Discount mp',
      'name' => 'discount_mp',
      'type' => 'number',
      'default_value' => 0,
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => 1,
      'step' => '0.05',
      ),
    array (
      'key' => 'field_566503074a0b1',
      'label' => 'Discount hp',
      'name' => 'discount_hp',
      'type' => 'number',
      'default_value' => 0,
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => 1,
      'step' => '0.05',
      ),
    array (
      'key' => 'field_5667d52339fff',
      'label' => 'Cena karty foil',
      'name' => 'cena_karty_foil',
      'type' => 'number',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => 0,
      'max' => 1,
      'step' => '0.05',
      ),
    array (
      'key' => 'field_Fb9qhJEmv0WUuSobu6',
      'label' => 'Cron',
      'name' => 'tab_5',
      'type' => 'tab',
      ),
    array (
      'key' => 'field_5665034c05193',
      'label' => 'Krok dla cron',
      'name' => 'krok_dla_cron',
      'type' => 'number',
      'instructions' => 'Nie zmieniaj tej liczby',
      'default_value' => 1,
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'min' => '',
      'max' => '',
      'step' => 1,
      ),
    array (
      'key' => 'field_566560c2a5440',
      'label' => 'ostatnie wykonanie',
      'name' => 'ostatnie_wykonanie',
      'type' => 'text',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'formatting' => 'html',
      'maxlength' => '',
      ),
    array (
      'key' => 'field_56a884751b8d0',
      'label' => 'ostatnia karta',
      'name' => 'ostatnia_karta',
      'type' => 'text',
      'default_value' => '',
      'placeholder' => '',
      'prepend' => '',
      'append' => '',
      'formatting' => 'html',
      'maxlength' => '',
      ),
    ),
'location' => array (
  array (
    array (
      'param' => 'options_page',
      'operator' => '==',
      'value' => 'acf-options',
      'order_no' => 0,
      'group_no' => 0,
      ),
    ),
  ),
'options' => array (
  'position' => 'normal',
  'layout' => 'no_box',
  'hide_on_screen' => array (
    ),
  ),
'menu_order' => 5,
));
}

?>