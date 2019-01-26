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
class A4N_MAIL_LIST_TABLE extends WP_List_Table {
    /**
	 * 初期化時の設定を行う
     * @extend
	 */
	public function __construct( $args = array() ) {
        parent::__construct( array(
			'singular' => 'a4n_pay_mail',
			'plural'   => 'a4n_pay_mails',
			'ajax'     => false,
	    ) );
    }
    
    /**
	 * 表で使用されるカラム情報の連想配列を返す
     * @extend
	 * @return array
	 */
	public function get_columns() {
        return array(
			'cb'		=> '<input type="checkbox" />',
			'key_type'	=> 'メールカテゴリ',
			'key_name'	=> 'メール件名',
	    );
    }

    /**
	 * プライマリカラム名を返す
     * @extend
	 * @return string
	 */
	protected function get_primary_column_name() {
        return 'key_type';
	}

    /**
	 * バルクアクションの取得
     * @extend
	 * @return array
	 */
	protected function get_bulk_actions() {
		return array( 'reset-selected' => __( 'Reset' ) );
	}
    
	/**
	 * 表示するデータを準備する
	 */
	public function prepare_items( $mail_templates = null ) {

        if ( !is_null( $mail_templates ) ) {
			$columns = $this->get_columns();
			$hidden = array();
			$sortable = $this->get_sortable_columns();

			$this->_column_headers = array($columns, $hidden, $sortable);

			 /**
			 * オプション。自由に一括操作を制御できます。
			 * このケースでは、きれいに保つためパッケージ内で制御します。
			 */
			$this->process_bulk_action();

			$this->items = $mail_templates;

            $this->set_pagination_args ( array(
                'total_items' => count( $mail_templates ),
                'per_page' => 10,
            ) );
		}

	}

	function process_bulk_action() {

		//Detect when a bulk action is being triggered...
		if( 'reset'===$this->current_action() ) {

			$target_key_list = get_option( 'a4n_pay_api_keys' );

			$new_array = array_filter( $target_key_list, function( $item ) {
				return $_REQUEST[ 'key_type' ] != $item[ 'key_type' ];
			} );

			update_option( 'a4n_pay_api_keys', $new_array );

			wp_die( '項目が削除されました。' );
		} elseif ( 'edit'===$this->current_action() ) {


		} elseif ( 'reset-selected'===$this->current_action() ) {
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
			'key_type'	=> 'メールカテゴリ',
			'key_name'	=> 'メール件名',
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
			'reset' => sprintf('<a href="?page=%s&action=%s&key_type=%s">初期化する</a>',$_REQUEST['page'],'reset',$type),
		);

		$type_name = '';
		switch ( $type ) {
			case 'deposit':
				$type_name = '決済完了時の証跡メール';
				break;
			case 'confirm':
				$type_name = 'メールアドレス確認時のメール';
				break;
		}

		//Return the title contents
		return sprintf('<span style="cursor:pointer">%1$s</span>%2$s',
			/*$2%s*/ $type_name,
			/*$3%s*/ $this->row_actions($actions)
		);
	}
}