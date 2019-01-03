<?php
if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

/**
* Regist API key Class
* This class composes the page of 'regist api key' page.
*
*/
class A4N_PAY_Api_Key_List_Table extends WP_List_Table {

	/**
	 * 初期化時の設定を行う
	 */
	public function __construct( $args = array() ) {
        parent::__construct( array(
			'singular' => 'a4n_pay_key',
			'plural'   => 'a4n_pay_keys',
			'ajax'     => false,
	    ) );
	}

	/**
	 * 表で使用されるカラム情報の連想配列を返す
	 * @return array
	 */
	public function get_columns() {
        return array(
			'cb'		=> '<input type="checkbox" />',
			'key_type'	=> 'キーの種類',
			'key_name'	=> 'APIキー名',
	    );
	}

	/**
	 * プライマリカラム名を返す
	 * @return string
	 */
	protected function get_primary_column_name() {
        return 'key_name';
	}

	protected function get_bulk_actions() {
		return array( 'delete-selected' => __( 'Delete' ) );
	}

	/**
	 * 表示するデータを準備する
	 */
	public function prepare_items( $api_key_list = null ) {

        if ( !is_null( $api_key_list ) ) {
			$columns = $this->get_columns();
			$hidden = array();
			$sortable = $this->get_sortable_columns();

			$this->_column_headers = array($columns, $hidden, $sortable);

			 /**
			 * オプション。自由に一括操作を制御できます。
			 * このケースでは、きれいに保つためパッケージ内で制御します。
			 */
			$this->process_bulk_action();

			$this->items = $api_key_list;

            $this->set_pagination_args ( array(
                'total_items' => count( $api_key_list ),
                'per_page' => 10,
            ) );
		}

	}

	function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if( 'delete'===$this->current_action() ) {

			$target_key_list = get_option( 'a4n_pay_api_keys' );

			$new_array = array_filter( $target_key_list, function( $item ) {
				return $_REQUEST[ 'key_type' ] != $item[ 'key_type' ];
			} );

			update_option( 'a4n_pay_api_keys', $new_array );

			wp_die( '項目が削除されました。' );
		} elseif ( 'edit'===$this->current_action() ) {


		} elseif ( 'delete-selected'===$this->current_action() ) {
			$target_key_list = get_option( 'a4n_pay_api_keys' );

			$new_array = array_filter( $target_key_list, function( $item ) {
				$exist_key = array_search( $item[ 'key_type' ],  $_REQUEST[ 'checked' ]);
				return $exist_key === false;
			} );

			update_option( 'a4n_pay_api_keys', $new_array );

			wp_die( '項目が削除されました。' );
		}

	}

	protected function get_sortable_columns() {
		return array(
				'no'	=> array( 'no', true ),
				'key_type'	=> 'key_type',
				'key_name'	=> 'key_name',
			 );
	}

	/**
	 * 1行分のデータを表示する
	 * @param array $item
	 */
	public function single_row( $item ) {

		list( $columns, $hidden, $sortable, $primary ) = $this->get_column_info();
		$columns = array(
			'cb'		=> '<input type="checkbox" />',
			'key_type'	=> 'キーの種類',
			'key_name'	=> 'APIキー名',
	    );
        ?>
        <tr>
        <?php

            foreach ( $columns as $column_name => $column_display_name ) {
				$classes = "$column_name column-$column_name";
				$extra_classes = '';
				if ( in_array( $column_name, $hidden ) ) {
					$extra_classes = ' hidden';
				}
                switch ( $column_name ) {
					case 'cb':
						$checkbox_id =  "checkbox_".$item['key_type'];
						$checkbox = "<label class='screen-reader-text' for='" . $checkbox_id . "' >" . sprintf( __( 'Select %s' ), $item['key_type'] ) . "</label>"
							. "<input type='checkbox' name='checked[]' value='" . $item['key_type']. "' id='" . $checkbox_id . "' />";
						echo "<th scope='row' class='check-column'>$checkbox</th>";
						break;
                    case 'key_type':
                    ?>
                        <td><?php echo $this->column_key_type( esc_attr( $item['key_type'] ) ); ?></td>
                    <?php
                        break;
                    case 'key_name':
                    ?>
                        <td><?php echo esc_attr( $item['key_name'] ); ?></td>
                    <?php
                }
            }
        ?>
        </tr>

        <?php

	}

	private function column_key_type( $type ) {

		 //Build row actions
		$actions = array(
			'edit' => sprintf('<a href="?page=%s&action=%s&key_type=%s">修正する</a>',$_REQUEST['page'],'edit',$type),
			'delete' => sprintf('<a href="?page=%s&action=%s&key_type=%s">削除する</a>',$_REQUEST['page'],'delete',$type),
		);

		$type_name = '';
		switch ( $type ) {
			case '0':
				$type_name = 'テスト秘密鍵';
				break;
			case '1':
				$type_name = 'テスト公開鍵';
				break;
			case '2':
				$type_name = '本番秘密鍵';
				break;
			case '3':
				$type_name = '本番公開鍵';
				break;
		}

		//Return the title contents
		return sprintf('<span style="cursor:pointer">%1$s</span>%2$s',
			/*$2%s*/ $type_name,
			/*$3%s*/ $this->row_actions($actions)
		);
	}
}
