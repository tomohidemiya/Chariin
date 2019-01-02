<?php
add_action( 'admin_init', 'a4n_post_update_mail_template' );
function a4n_post_update_mail_template() {
    if ( isset( $_GET['page']) && $_GET['page'] == 'a4n-chariin-mail-editor' ) {
		if ( isset( $_POST['mail_content']) ) {
			// POSTの時の処理する
			$category = $_POST['a4n_mail_category'];
			$from = $_POST['a4n_mail_from'];
			$cc = $_POST['a4n_mail_cc'];
			$bcc = $_POST['a4n_mail_bcc'];
			$subject = $_POST['a4n_mail_subject'];
			$mail_body = $_POST['a4n_mail_content'];
			// $headers = $_POST['a4n_mail_additional_headers'];
			// $attach = $_POST['a4n_mail_attachments'];
		} else {
			// GETの時の処理をする（これはいらんか）

		}
    } 
}

function a4n_chariin_mail_editor() {
	?>
	<div class="wrap">
        <h2>メール編集</h2>
        <p>
            安全な決済のために、顧客へのメール送付は必須です。<br />
			クレジットカードのように領収書を発行できないサービスの場合、メールを返送することによって<br />
			領収書の代わりになりますので、メール内容を設定してください。
        </p>
		<form id="mail_edit_form" method="post" action="">
			<!-- <input type="hidden" id=""> -->
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2" style="margin-right: 300px;	">
					<div id="post-body-content" style="position: relative;">
						<div id="postdivrich" class="postarea wp-editor-expand">
							<div id="wp-content-wrap" class="wp-core-ui wp-editor-wrap html-active has-dfw" style="padding-top: 55px;">
								<link rel="stylesheet" id="editor-buttons-css" href="/wp-includes/css/editor.min.css?ver=4.9.8" type="text/css" media="all">

								<div id="wp-content-editor-tools" class="wp-editor-tools hide-if-no-js" style="position: absolute; top: 0px; width: 100%;">
									<div id="wp-content-media-buttons" class="wp-media-buttons">
										<button type="button" id="insert-media-button" class="button insert-media add_media" data-editor="content">
											<span class="wp-media-buttons-icon"></span> 添付データの追加
										</button>
									</div>
									
								</div>
								<div id="wp-content-editor-container">
									<!-- <div id="ed_toolbar" class="quicktags-toolbar" style="position: absolute; top: 0px; width: 100%; padding: 0;">
										<input type="button" id="qt_content_strong" class="ed_button button button-small" aria-label="Bold" value="b">
										<input type="button" id="qt_content_em" class="ed_button button button-small" aria-label="Italic" value="i">
										<input type="button" id="qt_content_link" class="ed_button button button-small" aria-label="Insert link" value="link">
										<input type="button" id="qt_content_block" class="ed_button button button-small" aria-label="Blockquote" value="b-quote">
										<input type="button" id="qt_content_del" class="ed_button button button-small" aria-label="Deleted text (strikethrough)" value="del">
										<input type="button" id="qt_content_ins" class="ed_button button button-small" aria-label="Inserted text" value="ins">
										<input type="button" id="qt_content_img" class="ed_button button button-small" aria-label="Insert image" value="img">
										<input type="button" id="qt_content_ul" class="ed_button button button-small" aria-label="Bulleted list" value="ul">
										<input type="button" id="qt_content_ol" class="ed_button button button-small" aria-label="Numbered list" value="ol">
										<input type="button" id="qt_content_li" class="ed_button button button-small" aria-label="List item" value="li">
										<input type="button" id="qt_content_code" class="ed_button button button-small" aria-label="Code" value="code">
										<input type="button" id="qt_content_more" class="ed_button button button-small" aria-label="Insert Read More tag" value="more">
										<input type="button" id="qt_content_close" class="ed_button button button-small" title="Close all open tags" value="close tags">
										<button type="button" id="qt_content_dfw" class="ed_button qt-dfw" title="Distraction-free writing mode"></button>
									</div> -->
									<table class="form-table">
										<tbody>
											<tr class="form-field form-required">
												<th scope="row">
													<label for="mail-from">
														メールの種類
														<span class="description">(必須)</span>
													</label>
												</th>
												<td>
													<select name="a4n_mail_category" id="mail-category">
														<option value="deposit">決済完了時の証跡メール</option>
														<option value="confirm">メールアドレス確認時のメール</option>
													</select>
												</td>
											</tr>
											<tr class="form-field form-required">
												<th scope="row">
													<label for="mail-from">
														差出人
														<span class="description">(必須)</span>
													</label>
												</th>
												<td>
													<input type="text" name="a4n_mail_from" id="mail-from" value="<?php echo('hoge') ?>">
												</td>
											</tr>
											<tr class="form-field">
												<th scope="row">
													<label for="mail-cc">
														CC
													</label>
												</th>
												<td>
													<input type="text" name="a4n_mail_cc" id="mail-cc" value="<?php echo('cc') ?>">
												</td>
											</tr>
											<tr class="form-field">
												<th scope="row">
													<label for="mail-bcc">
														BCC
													</label>
												</th>
												<td>
													<input type="text" name="a4n_mail_bcc" id="mail-bcc" value="<?php echo('bcc') ?>">
												</td>
											</tr>
											<tr class="form-field">
												<th scope="row">
													<label for="mail-subject">
														メール件名
														<span class="description">(必須)</span>
													</label>
												</th>
												<td>
													<input type="text" name="a4n_mail_subject" id="mail-subject" value="<?php echo('subject') ?>">
												</td>
											</tr>
											<tr class="form-field">
												<th scope="row">
													<label for="mail-content">
														メール本文
														<span class="description">(必須)</span>
													</label>
												</th>
												<td>
													<textarea id="mail-content" style="height: 300px;" autocomplete="off" cols="40" name="a4n_mail_content" id="mail_content"><?php echo('content') ?></textarea>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<div class="uploader-editor" style="display: none;">
									<div class="uploader-editor-content">
										<div class="uploader-editor-title">Drop files to upload</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div id="postbox-container-1" class="postbox-container" style="float: right;width: 280px;">
					<div id="side-sortables" class="meta-box-sortables ui-sortable">
						<div id="submitdiv" class="postbox">
							<button type="button" class="handlediv" aria-expanded="true">
								<span class="screen-reader-text">Toggle panel: Publish</span>
								<span class="toggle-indicator" aria-hidden="true"></span>
							</button>
							<h2 class="hndle ui-sortable-handle"><span>Publish</span></h2>
							<div class="inside">
								<div class="submitbox" id="submitpost">
									<div id="minor-publishing">
										<div id="minor-publishing-actions">
											<div id="save-action">
												<input type="submit" name="save" id="save-post" value="Save Draft" class="button">
												<span class="spinner"></span>
											</div>
											<div id="test-mail-action">
												<a class="test button" href="#" id="post-test-mail">Mail Test<span class="screen-reader-text"> (sends email to a your address)</span></a>
											</div>
											<div class="clear"></div>
										</div>

										<div id="misc-publishing-actions">
											<div class="misc-pub-section misc-pub-post-status">
												Status: <span id="post-status-display">Draft</span>
												<a href="#post_status" class="edit-post-status hide-if-no-js" role="button"><span aria-hidden="true">Edit</span> <span class="screen-reader-text">Edit status</span></a>

												<div id="post-status-select" class="hide-if-js">
													<input type="hidden" name="hidden_post_status" id="hidden_post_status" value="draft">
													<label for="post_status" class="screen-reader-text">Set status</label>
													<select name="post_status" id="post_status">
														<option value="pending">Pending Review</option>
														<option selected="selected" value="draft">Draft</option>
													</select>
													<a href="#post_status" class="save-post-status hide-if-no-js button">OK</a>
													<a href="#post_status" class="cancel-post-status hide-if-no-js button-cancel">Cancel</a>
												</div>

											</div><!-- .misc-pub-section -->

											<div class="clear"></div>
										</div>
										<div id="major-publishing-actions">
											<div id="delete-action">
												<a class="submitdelete deletion" href="#">Reset</a>
											</div>
											<div id="publishing-action">
												<span class="spinner"></span>
												<!-- <input name="original_publish" type="hidden" id="original_publish" value="Publish"> -->
												<input type="submit" name="publish" id="publish" class="button button-primary button-large" value="Publish">
											</div>
											<div class="clear"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
    </div>
	<?php
	return '';
}
