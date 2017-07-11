<?php

/****************************************************
*                         *
* Register acf fields for billing summaries   *
*                         *
****************************************************/

if ( function_exists( "register_field_group" ) ) {

  register_field_group(
    array(
      'id'      =>  'billing_summaries',
      'title'     =>  __( 'Billing summaries', 'sage' ),
      'fields'    =>  array(
        array(
          'key'   => 'field_RiqePmsPLZx5f04bSQ6F',
          'label' => __( 'Total', 'sage' ),
          'name'  => 'billing_total',
          'type'  => 'number'
          ),
        array(
          'key'   => 'field_uOa6uvOi5JCl',
          'label' => __( 'Team', 'sage' ),
          'name'  => 'billing_team',
          'type'  => 'number'
          ),
        array(
          'key'   => 'field_Y8Yi8wKkCM0d8h',
          'label' => __( 'Leszek', 'sage' ),
          'name'  => 'billing_leszek',
          'type'  => 'number'
          ),
        array(
          'key'   => 'field_KD6cjD02XXrd2repEeVw',
          'label' => __( 'Sławek', 'sage' ),
          'name'  => 'billing_slawek',
          'type'  => 'number'
          ),
        ),
      'location'    =>  array(
        array(
          array(
            'param'   =>  'options_page',
            'operator'  =>  '==',
            'value'   =>  'acf-options',
            'order_no'  =>  5,
            'group_no'  =>  5
            ),
          ),
        ),
      'options'   =>  array(
        'position'      =>  'normal',
        'layout'      =>  'default',
        ),
      'menu_order'  =>  15
      )
    );

}

/********************************************
*                     *
* Register acf fields for basket post   *
*                     *
********************************************/

if ( function_exists( "register_field_group" ) ) {

  register_field_group(
    array(
      'id'        =>  'chosen_cards',
      'title'     =>  __( 'Picked cards', 'sage' ),
      'fields'    =>  array(
        array(
          'key'             =>  'field_cq8',
          'label'           =>  __( 'Card', 'sage' ),
          'name'            =>  'cards_list',
          'type'            =>  'repeater',
          'button_label'    =>  __( 'Add next card', 'sage' ),
          'row_min'         =>  0,
          'layout'          =>  'table',
          'sub_fields'      =>  array(
            array(
              'key'                   =>  'field_dWH',
              'label'                 =>  __( 'Name', 'sage' ),
              'name'                  =>  'card_name',
              'type'                  =>  'post_object',
              'post_type'             =>  array(
                'post',
                ),
              'allow_null'            =>  1
              ),
            array(
              'key'                   =>  'field_hgRSc2lucgh8v',
              'label'                 =>  __( 'Price', 'sage' ),
              'name'                  =>  'card_price',
              'type'                  =>  'number',
              'step'                  => 1
              ),
            array(
              'key'                   =>  'field_i8xSMz39A',
              'label'                 =>  __( 'Amount', 'sage' ),
              'name'                  =>  'card_amount',
              'type'                  =>  'number',
              'allow_null'            =>  0
              ),
            ),
          ),
        array(
          'key'             =>  'field_kLmz1uSyMaaw',
          'label'           =>  __( 'Basket discount', 'sage' ),
          'name'            =>  'basket_discount',
          'type'            =>  'number',
          'step'            => 1,
          'min'             => 0,
          ),
        array(
          'key'             =>  'field_FYn6sNBSpe5hFqABDyz',
          'label'           =>  __( 'Basket shipping cost', 'sage' ),
          'name'            =>  'basket_shipping_cost',
          'type'            =>  'number',
          'step'            => 1,
          'min'             => 0,
          ),
        array(
          'key'             =>  'field_mUU',
          'label'           =>  __( 'Basket team sum', 'sage' ),
          'name'            =>  'basket_team_sum',
          'type'            =>  'number',
          'step'            => 1
          ),
        array(
          'key'             =>  'field_tOwppkhoDVeeZVRksTfk',
          'label'           =>  __( 'Basket Leszek sum', 'sage' ),
          'name'            =>  'basket_leszek_sum',
          'type'            =>  'number',
          'step'            => 1
          ),
        array(
          'key'             =>  'field_xuurADfHwNiwcalbUK',
          'label'           =>  __( 'Basket Sławek sum', 'sage' ),
          'name'            =>  'basket_slawek_sum',
          'type'            =>  'number',
          'step'            => 1
          ),
        array(
          'key'             =>  'field_CPWDI63YfPv',
          'label'           =>  __( 'Basket total sum', 'sage' ),
          'name'            =>  'basket_total_sum',
          'type'            =>  'number',
          'step'            => 1
          ),
        array(
          'key'             =>  'field_EaAnmrU6Iy',
          'label'           =>  __( 'Basket status', 'sage' ),
          'name'            =>  'basket_status',
          'type'            =>  'select',
          'choices'         =>  array(
            'preorder'                =>  __( 'Pre order', 'sage' ),
            // 'for_shipping'            =>  __( 'For shipping', 'sage' ),
            'shipped'                 =>  __( 'Shipped', 'sage' ),
            'billed'                  =>  __( 'Billed', 'sage' ),
            ),
          ),
        ),
      'location'    =>  array(
        array(
          array(
            'param'         =>  'post_type',
            'operator'      =>  '==',
            'value'         =>  'basket',
            'order_no'      =>  1,
            'group_no'      =>  1
            ),
          ),
        ),
      'options'     =>  array(
        'position'          =>  'normal',
        'layout'            =>  'default',
        'hide_on_screen'    =>  array(
          ),
        ),
      'menu_order'  =>  1
      )
);

}

/****************************************************
*                         *
* Register acf fields for cron job summaries   *
*                         *
****************************************************/

if ( function_exists( "register_field_group" ) ) {

  register_field_group(
    array(
      'id'        =>  'zmienne_dla_cron',
      'title'     =>  __( 'Zmienne dla cron', 'sage' ),
      'fields'    =>  array(
        array(
          'key'               => 'field_tPWMhM',
          'label'             => __( 'Step', 'sage' ),
          'name'              => 'krok_dla_cron',
          'type'              => 'number'
          ),
        array(
          'key'               => 'field_3RWH2cyLwknikHTxJH12',
          'label'             => __( 'Last launch', 'sage' ),
          'name'              => 'ostatnie_wykonanie',
          'type'              => 'text'
          ),
        array(
          'key'               => 'field_TZoSjtPRBG4nsaL7lMTr',
          'label'             => __( 'Last card', 'sage' ),
          'name'              => 'ostatnia_karta',
          'type'              => 'text'
          ),
        ),
      'location'  =>  array(
        array(
          array(
            'param'           =>  'options_page',
            'operator'        =>  '==',
            'value'           =>  'acf-options',
            'order_no'        =>  10,
            'group_no'        =>  10
            ),
          ),
        ),
      'options'   =>  array(
        'position'            =>  'normal',
        'layout'              =>  'default',
        ),
      'menu_order'=>  10
      )
    );

}

/**********************************
*                                 *
* Register acf fields for posts   *
*                                 *
**********************************/

if ( function_exists( "register_field_group" ) ) {

  // cards description
  register_field_group(
    array(
      'id'        =>  'desc',
      'title'     =>  __( 'Card description', 'sage' ),
      'fields'    =>  array(
        array(
          'key'               => 'field_Ur98jauq1nlVJVXHv',
          'label'             => __( 'Edition', 'sage' ),
          'name'              => 'edycja',
          'type'              => 'radio',
          'layout'            => 'horizontal',
          'other_choice'      => 1,
          'save_other_choice' => 1,
          'allow_null'        => 0,
          'choices'           => array(
            'Avacyn Restored'                     => 'Avacyn Restored',
            'Battle for Zendikar'                 => 'Battle for Zendikar',
            'Battle for Zendikar: Promos'         => 'Battle for Zendikar: Promos',
            'Conflux'                             => 'Conflux',
            'Dark Ascension'                      => 'Dark Ascension',
            'Dissension'                          => 'Dissension',
            'Dragons of Tarkir'                   => 'Dragons of Tarkir',
            'Duel Decks: Ajani vs. Nicol Bolas'   => 'Duel Decks: Ajani vs. Nicol Bolas',
            'Duel Decks: Elspeth vs. Tezzeret'    => 'Duel Decks: Elspeth vs. Tezzeret',
            'Duel Decks: Zendikar vs. Eldrazi'    => 'Duel Decks: Zendikar vs. Eldrazi',
            'Eighth Edition'                      => 'Eighth Edition',
            'Fate Reforged'                       => 'Fate Reforged',
            'Fifth Dawn'                          => 'Fifth Dawn',
            'Friday Night Magic Promos'           => 'Friday Night Magic Promos',
            'Future Sight'                        => 'Future Sight',
            'Grand Prix Promos'                   => 'Grand Prix Promos',
            'Innistrad'                           => 'Innistrad',
            'Judge Rewards Promos'                => 'Judge Rewards Promos',
            'Khans of Tarkir'                     => 'Khans of Tarkir',
            'Magic 2015'                          => 'Magic 2015',
            'Mirrodin Besieged'                   => 'Mirrodin Besieged',
            'Modern Masters'                      => 'Modern Masters',
            'Modern Masters 2015'                 => 'Modern Masters 2015',
            'Morningtide'                         => 'Morningtide',
            'Nemesis'                             => 'Nemesis',
            'Oath of the Gatewatch'               => 'Oath of the Gatewatch',
            'Portal Second Age'                   => 'Portal Second Age',
            'Ravnica: City of Guilds'             => 'Ravnica: City of Guilds',
            'Saviors of Kamigawa'                 => 'Saviors of Kamigawa',
            'Scars of Mirrodin'                   => 'Scars of Mirrodin',
            'Seventh Edition'                     => 'Seventh Edition',
            'Shadows over Innistrad'              => 'Shadows over Innistrad',
            'Shadows over Innistrad: Promos'      => 'Shadows over Innistrad: Promos',
            'Tenth Edition'                       => 'Tenth Edition',
            'Theros'                              => 'Theros',
            'Time Spiral'                         => 'Time Spiral',
            'Torment'                             => 'Torment',
            'Unglued'                             => 'Unglued',
            'Unhinged'                            => 'Unhinged',
            'Urza\'s Saga'                        => 'Urza\'s Saga',
            'Weatherlight'                        => 'Weatherlight',
            'Worldwake'                           => 'Worldwake',
            'Zendikar'                            => 'Zendikar',
            )
          ),
        array(
          'key'               => 'field_zM2qUEMH',
          'label'             => __( 'Condition', 'sage' ),
          'name'              => 'stan',
          'type'              => 'radio',
          'layout'            => 'horizontal',
          'other_choice'      => 0,
          'save_other_choice' => 0,
          'allow_null'        => 0,
          'choices'           => array(
            "nm"                                  => "Near Mint",
            "lp"                                  => "Lightly Played",
            "mp"                                  => "Moderately Played",
            "hp"                                  => "Heavily Played",
            )
          ),
        array(
          'key'               => 'field_izUOJl72xvMZR',
          'label'             => __( 'Language', 'sage' ),
          'name'              => 'jezyk',
          'type'              => 'radio',
          'layout'            => 'horizontal',
          'other_choice'      => 1,
          'save_other_choice' => 1,
          'allow_null'        => 0,
          'choices'           => array(
            "eng"                                 => "Angielski",
            "de"                                  => "Niemiecki",
            "fr"                                  => "Francuski",
            "it"                                  => "Włoski",
            "sp"                                  => "Hiszpański",
            "ru"                                  => "Rosyjski",
            "jpn"                                 => "Japoński",
            "kor"                                 => "Koreański",
            "chi"                                 => "Chiński",
            ),
          'default_value'     => 'nm',
          ),
        array(
          'key'               => 'field_yMb',
          'label'             => __( 'Amount', 'sage' ),
          'name'              => 'ilosc',
          'type'              => 'number',
          'step'              => 1,
          'min'               => 1,
          'default_value'     => 1,
          'allow_null'        => 0,
          ),
        array(
          'key'               => 'field_V9Mkb3c5R6q',
          'label'             => __( 'Sold', 'sage' ),
          'name'              => 'sprzedane',
          'type'              => 'number',
          'step'              => 1,
          'min'               => 0,
          'default_value'     => 0,
          'allow_null'        => 1,
          ),
        array(
          'key'                 => 'field_jyd3bPOjuu6',
          'label'               => __( 'Reserved', 'sage' ),
          'name'                => 'cards_reserved',
          'type'                => 'number',
          'min'                 => 0,
          'default_value'       => 0,
          'step'                => 1
          ),
        array(
          'key'               => 'field_ymtZoxo',
          'label'             => __( 'Price', 'sage' ),
          'name'              => 'cena',
          'type'              => 'number',
          'step'              => 1,
          'min'               => 1,
          'default_value'     => 1,
          'allow_null'        => 1,
          ),
        array(
          'key'               => 'field_CUlm12G5BgwhkI9rg',
          'label'             => __( 'Discount', 'sage' ),
          'name'              => 'discount',
          'type'              => 'number',
          'step'              => 0.05,
          'min'               => 0,
          'max'               => 1,
          'default_value'     => 0,
          'allow_null'        => 1,
          ),
        array(
          'key'               => 'field_hAm',
          'label'             => __( 'Notes', 'sage' ),
          'name'              => 'uwagi',
          'type'              => 'text'
          ),
        array(
          'key'               => 'field_7WuA2uWO8ffoCze7vpU',
          'label'             => __( 'Rarity', 'sage' ),
          'name'              => 'rarity',
          'type'              => 'radio',
          'layout'            => 'horizontal',
          'other_choice'      => 1,
          'save_other_choice' => 1,
          'allow_null'        => 0,
          'choices'           => array(
            "1"                                   => "Mythic",
            "2"                                   => "Rare",
            "3"                                   => "Uncommon",
            "4"                                   => "Common",
            "5"                                   => "Error",
            "6"                                   => "Land",
            ),
          'default_value'     => '5',
          ),
        array(
          'key'               => 'field_ZKygXpkReJG',
          'label'             => __( 'Foil', 'sage' ),
          'name'              => 'foil',
          'type'              => 'true_false',
          'default_value'     => 0,
          ),
        array(
          'key'               => 'field_5tZNy',
          'label'             => __( 'Ownership', 'sage' ),
          'name'              => 'własność',
          'type'              => 'radio',
          'layout'            => 'horizontal',
          'other_choice'      => 1,
          'save_other_choice' => 1,
          'allow_null'        => 0,
          'choices'           => array(
            "Team"                                => "Team",
            "Leszek"                              => "Leszek",
            "Sławek"                              => "Sławek",
            ),
          'default_value'     => 'Team',
          ),     
        ),
'location'        =>  array(
  array(
    array(
      'param'                 =>  'post_type',
      'operator'              =>  '==',
      'value'                 =>  'post',
      'order_no'              =>  0,
      'group_no'              =>  0
      ),
    ),
  ),
'options'         =>  array(
  'position'                  =>  'normal',
  'layout'                    =>  'default',
  'hide_on_screen'            => array(
    ),
  ),
'menu_order'      =>  10
)
);

  // single post media
register_field_group(
  array(
    'id'           =>  'media',
    'title'        =>  __( 'Media', 'sage' ),
    'fields'       =>  array(
      array(
        'key'                 => 'field_YpPw39Rb1ZkXOVxjv6du',
        'label'               => __( 'Image link', 'sage' ),
        'name'                => 'img_link',
        'type'                => 'text'
        ),
      array(
        'key'                 => 'field_Sm8ym3eBoW6',
        'label'               => __( 'Card link', 'sage' ),
        'name'                => 'link_do_karty',
        'type'                => 'text'
        ),
      ),
    'location'    =>  array(
      array(
        array(
          'param'             =>  'post_type',
          'operator'          =>  '==',
          'value'             =>  'post',
          'order_no'          =>  1,
          'group_no'          =>  1
          ),
        ),
      ),
    'options'     =>  array(
      'position'              =>  'normal',
      'layout'                =>  'default',
      'hide_on_screen'        => array(
        ),
      ),
    'menu_order'  =>  10
    )
  );

}