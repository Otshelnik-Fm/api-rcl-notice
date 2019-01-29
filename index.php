<?php

/*

╔═╗╔╦╗╔═╗╔╦╗
║ ║ ║ ╠╣ ║║║ https://otshelnik-fm.ru
╚═╝ ╩ ╚  ╩ ╩

*/


// для теста выводи шорткодом [apin_get_notice]
function apin_shortcode(){
    return apin_demo_get_notice();
}
add_shortcode('apin_get_notice', 'apin_shortcode');



/**
 * Get notice block.
 *
 * @since 17.0
 *
 * @param array $params {
 *     Array arguments.
 *
 *     @type string $header			Header text. Default empty.
 *     @type string $text			Message text. Default empty.
 *     @type string $type			Type of block: 'info' (yellow), 'success' (green), 'warning' (red), 'simple' (light grey).
 *									Default 'info'.
 *     @type bool $is_icon			Return icon. Default true.
 *     @type string $icon			Alternate rcl-awesome icon. Default empty.
 *     @type string $class			Additional class of block. Default empty.
 *     @type bool $border			Border on box. Default false.
 *     @type string $cookie_id		if you want to close the block - set a unique ID. Default false.
 *     @type int $cookie_time		Sets cookie lifetime. Default '30' days.
 * }
 */
function rcl_notice_block( $params ) {
	$defaults	 = [
		'header'		 => '',
		'text'			 => '',
		'type'			 => 'info',
		'is_icon'		 => true,
		'icon'			 => '',
		'class'			 => '',
		'border'		 => false,
		'cookie_id'		 => false,
		'cookie_time'	 => false
	];
	$args = wp_parse_args( $params, $defaults );

    if ( !empty( $args['cookie_id'] ) && isset( $_COOKIE[$args['cookie_id']] ) )
		return;

	$icon = '';

	if ( !empty( $args['is_icon'] ) && empty( $args['icon'] ) ) {
		switch ( $args['type'] ) {
			case 'success':
				$icon	 = 'fa-check-circle';
				break;
			case 'warning':
				$icon	 = 'fa-exclamation-circle';
				break;
			case 'info':
				$icon	 = 'fa-info-circle';
				break;
		}
	} else if ( !empty( $args['is_icon'] ) && isset( $args['icon'] ) ) {
		$icon = $args['icon'];
	}

	$border = !empty( $args['border'] ) ? 'gtr_border' : '';

	$notice_block	 = '<div class="gtr_notify gtr_' . $args['type'] . ' ' . $args['class'] . ' ' . $border . '">';
	if ( !empty( $args['is_icon'] ) && $args['type'] != 'simple' )
		$notice_block	 .= '<i class="rcli ' . $icon . '" aria-hidden="true"></i>';

	if ( !empty( $args['cookie_id'] ) ) {
		$time		 = !empty( $args['cookie_time'] ) ? $args['cookie_time'] : '30';
		$data_attrs	 = 'data-gtr_notice_id="' . $args['cookie_id'] . '" data-gtr_notice_time="' . $time . '"';

		$notice_block .= '<div class="gtr_close" ' . $data_attrs . ' onclick="rclCloseNotice(this);return false;"></div>';
	}

	if ( !empty( $args['header'] ) )
		$notice_block .= '<div class="gtr_notify_header">' . $args['header'] . '</div>';

	$notice_block	 .= '<div class="gtr_notify_text">' . $args['text'] . '</div>';
	$notice_block	 .= '</div>';

	return $notice_block;
}




add_action( 'rcl_enqueue_scripts', 'apin_resources', 10 );
function apin_resources() {
	rcl_enqueue_script( 'apin_script', rcl_addon_url( 'src/script.js', __FILE__ ) );
	rcl_enqueue_style( 'apin_style', rcl_addon_url( 'src/style.css', __FILE__ ) );
}




// выведем тестовые нотисы для наглядности и проверки вёрстки
function apin_demo_get_notice() {
$out ='<h3>Виды блоков:</h3>';
	$out .='<div>info блок</div>';

	$data1 = [
		'text'	 => 'Это закрытая группа. Вступите в группу чтоб ништяков словить'
	];
	$out .= rcl_notice_block( $data1 );


	$out .='<div>success блок</div>';
	$data2 = [
		'type'	 => 'success',
		'text'	 => 'Всё успешно загружено'
	];
	$out .= rcl_notice_block( $data2 );


	$out .='<div>warning блок</div>';
	$data3 = [
		'type'	 => 'warning',
		'text'	 => 'Вы были забанены'
	];
	$out .= rcl_notice_block( $data3 );


	$out .='<div>simple блок</div>';
	$data4 = [
		'type'	 => 'simple',
		'text'	 => 'Публикаций пока нет'
	];
	$out .= rcl_notice_block( $data4 );


$out .='<h3>Виды блоков с бордером:</h3>';
	$data21 = [
		'border' => true,
		'text'	 => 'Это закрытая группа. Вступите в группу чтоб ништяков словить'
	];
	$out .= rcl_notice_block( $data21 );

	$data22 = [
		'border' => true,
		'type'	 => 'success',
		'text'	 => 'Всё успешно загружено'
	];
	$out .= rcl_notice_block( $data22 );


	$data23 = [
		'border' => true,
		'type'	 => 'warning',
		'text'	 => 'Вы были забанены'
	];
	$out .= rcl_notice_block( $data23 );


	$data24 = [
		'border' => true,
		'type'	 => 'simple',
		'text'	 => 'Публикаций пока нет'
	];
	$out .= rcl_notice_block( $data24 );



$out .='<h3>Укажем заголовок:</h3>';
	$data5 = [
		'type'	 => 'warning',
		'header' => 'Внимание!',
		'text'	 => 'Вы забанены в группе. Возможность комментирования вам недоступна'
	];
	$out .= rcl_notice_block( $data5 );


$out .='<h3>Укажем заголовок, иконку и бордер:</h3>';
	$data6 = [
		'type'	 => 'warning',
		'header' => 'Внимание!!!',
		'icon'	 => 'fa-trash',
		'border' => true,
		'text'	 => 'Вы собираетесь удалить профиль. Уверены?'
	];
	$out .= rcl_notice_block( $data6 );


$out .='<h3>Произвольная иконка и бордер:</h3>';
	$data7 = [
		'icon'	 => 'fa-lock',
		'border' => true,
		'text'	 => 'Это закрытая группа. Войдите на сайт и вступите в группу. Тогда вы сможете увидеть записи в ней и следить за обновлениями.'
	];
	$out .= rcl_notice_block( $data7 );


$out .='<h3>Без иконки:</h3>';
	$data8 = [
		'is_icon'	 => false,
		'type'	 => 'success',
		'text'	 => 'Публикаций пока нет'
	];
	$out .= rcl_notice_block( $data8 );


$out .='<h3>Своя иконка и кукис на 1 день - крестик "скрыть сообщение":</h3>';
	$data9 = [
		'icon'	 => 'fa-shopping-basket',
		'cookie_id' => 'apin_logged_message',
		'cookie_time'	 => 1,
		'border' => true,
		'text'	 => 'Это закрытая группа. Войдите на сайт и вступите в группу. Тогда вы сможете увидеть записи в ней и следить за обновлениями.'
	];
	$out .= rcl_notice_block( $data9 );

	$out .='<div>по дефолту кука на 30 дней</div>';
	$data10 = [
		'icon'	 => 'fa-trophy',
		'cookie_id' => 'apin_prize_message',
		'border' => true,
		'header' => 'Вы достигли нового уровня',
		'text'	 => 'Теперь вам доступны новые возможности. В настройках профиля смотрите подробности.'
	];
	$out .= rcl_notice_block( $data10 );

	return $out;
}
