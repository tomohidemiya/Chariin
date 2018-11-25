<?php
function a4n_chariin_mail_editor() {
	?>
	<div class="wrap">
        <h2>メール編集</h2>
        <p>
            安全な決済のために、顧客へのメール送付は必須です。<br />
			クレジットカードのように領収書を発行できないサービスの場合、メールを返送することによって<br />
			領収書の代わりになりますので、メール内容を設定してください。
        </p>
		<form action="post.php">
			<!-- <input type="hidden" id=""> -->
			<div id="poststuff">
				<div id="post-body" class="metabox-holder columns-2" style="margin-right: 300px;	">
					<div id="post-body-content" style="position: relative;">
						<div id="titlediv">
							<div id="titlewrap">
								<label class="" id="title-prompt-text" for="title">タイトル</label>
								<input type="text" name="post_title" size="30" value="" id="title" spellcheck="true" autocomplete="off">
							</div>
							<div class="inside">
								<div id="edit-slug-box" class="hide-if-no-js"></div>
							</div>
							<input type="hidden" id="samplepermalinknonce" name="samplepermalinknonce" value="5c1ec31a03">
						</div>
						<div id="postdivrich" class="postarea wp-editor-expand">
							<div id="wp-content-wrap" class="wp-core-ui wp-editor-wrap html-active has-dfw" style="padding-top: 55px;">
								<link rel="stylesheet" id="editor-buttons-css" href="/wp-includes/css/editor.min.css?ver=4.9.8" type="text/css" media="all">

								<div id="wp-content-editor-tools" class="wp-editor-tools hide-if-no-js" style="position: absolute; top: 0px; width: 938px;">
									<div id="wp-content-media-buttons" class="wp-media-buttons">
										<button type="button" id="insert-media-button" class="button insert-media add_media" data-editor="content">
											<span class="wp-media-buttons-icon"></span> メディアの追加
										</button>
									</div>
									<div class="wp-editor-tabs">
										<button type="button" id="content-tmce" class="wp-switch-editor switch-tmce" data-wp-editor-id="content">ビジュアル</button>
										<button type="button" id="content-html" class="wp-switch-editor switch-html" data-wp-editor-id="content">テキスト</button>
									</div>
								</div>
								<div id="wp-content-editor-container" class="wp-editor-container">
									<div id="ed_toolbar" class="quicktags-toolbar" style="position: absolute; top: 0px; width: 898px;">
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
									</div>
									<textarea class="wp-editor-area" style="height: 300px; margin-top: 37px;" autocomplete="off" cols="40" name="content" id="content"></textarea>
								</div>
								<div class="uploader-editor" style="display: none;">
									<div class="uploader-editor-content">
										<div class="uploader-editor-title">Drop files to upload</div>
									</div>
								</div>
							</div>
							<table id="post-status-info" style="">
								<tbody>
									<tr>
										<td id="wp-word-count" class="hide-if-no-js">Word count: <span class="word-count">0</span></td>
										<td class="autosave-info"><span class="autosave-message">&nbsp;</span></td>
										<td id="content-resize-handle" class="hide-if-no-js"><br></td>
									</tr>
								</tbody>
							</table>
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
											<div id="preview-action">
												<a class="preview button" href="#" target="wp-preview-169" id="post-preview">Preview<span class="screen-reader-text"> (opens in a new window)</span></a>
												<input type="hidden" name="wp-preview" id="wp-preview" value="">
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

											<div class="misc-pub-section misc-pub-visibility" id="visibility">
												Visibility: <span id="post-visibility-display">Public</span>
												<a href="#visibility" class="edit-visibility hide-if-no-js" role="button"><span aria-hidden="true">Edit</span> <span class="screen-reader-text">Edit visibility</span></a>

												<div id="post-visibility-select" class="hide-if-js">
													<input type="hidden" name="hidden_post_password" id="hidden-post-password" value="">
													<input type="checkbox" style="display:none" name="hidden_post_sticky" id="hidden-post-sticky" value="sticky">
													<input type="hidden" name="hidden_post_visibility" id="hidden-post-visibility" value="public">
													<input type="radio" name="visibility" id="visibility-radio-public" value="public" checked="checked"> <label for="visibility-radio-public" class="selectit">Public</label><br>
													<span id="sticky-span"><input id="sticky" name="sticky" type="checkbox" value="sticky"> <label for="sticky" class="selectit">Stick this post to the front page</label><br></span>
													<input type="radio" name="visibility" id="visibility-radio-password" value="password"> <label for="visibility-radio-password" class="selectit">Password protected</label><br>
													<span id="password-span"><label for="post_password">Password:</label> <input type="text" name="post_password" id="post_password" value="" maxlength="255"><br></span>
													<input type="radio" name="visibility" id="visibility-radio-private" value="private"> <label for="visibility-radio-private" class="selectit">Private</label><br>

													<p>
														<a href="#visibility" class="save-post-visibility hide-if-no-js button">OK</a>
														<a href="#visibility" class="cancel-post-visibility hide-if-no-js button-cancel">Cancel</a>
													</p>
												</div>

											</div><!-- .misc-pub-section -->

											<div class="misc-pub-section curtime misc-pub-curtime">
												<span id="timestamp">Publish <b>immediately</b></span>
												<a href="#edit_timestamp" class="edit-timestamp hide-if-no-js" role="button"><span aria-hidden="true">Edit</span> <span class="screen-reader-text">Edit date and time</span></a>
												<fieldset id="timestampdiv" class="hide-if-js">
													<legend class="screen-reader-text">Date and time</legend>
													<div class="timestamp-wrap">
														<label><span class="screen-reader-text">Month</span>
															<select id="mm" name="mm">
																<option value="01" data-text="Jan">01-Jan</option>
																<option value="02" data-text="Feb">02-Feb</option>
																<option value="03" data-text="Mar">03-Mar</option>
																<option value="04" data-text="Apr">04-Apr</option>
																<option value="05" data-text="May">05-May</option>
																<option value="06" data-text="Jun">06-Jun</option>
																<option value="07" data-text="Jul">07-Jul</option>
																<option value="08" data-text="Aug">08-Aug</option>
																<option value="09" data-text="Sep">09-Sep</option>
																<option value="10" data-text="Oct">10-Oct</option>
																<option value="11" data-text="Nov" selected="selected">11-Nov</option>
																<option value="12" data-text="Dec">12-Dec</option>
															</select>
														</label>
														<label><span class="screen-reader-text">Day</span>
															<input type="text" id="jj" name="jj" value="24" size="2" maxlength="2" autocomplete="off">
														</label>,
														<label>
															<span class="screen-reader-text">Year</span><input type="text" id="aa" name="aa" value="2018" size="4" maxlength="4" autocomplete="off">
														</label> @
														<label>
															<span class="screen-reader-text">Hour</span><input type="text" id="hh" name="hh" value="12" size="2" maxlength="2" autocomplete="off">
														</label>:
														<label>
															<span class="screen-reader-text">Minute</span><input type="text" id="mn" name="mn" value="44" size="2" maxlength="2" autocomplete="off">
														</label>
													</div>
													<input type="hidden" id="ss" name="ss" value="41">
													<input type="hidden" id="hidden_mm" name="hidden_mm" value="11">
													<input type="hidden" id="cur_mm" name="cur_mm" value="11">
													<input type="hidden" id="hidden_jj" name="hidden_jj" value="24">
													<input type="hidden" id="cur_jj" name="cur_jj" value="25">
													<input type="hidden" id="hidden_aa" name="hidden_aa" value="2018">
													<input type="hidden" id="cur_aa" name="cur_aa" value="2018">
													<input type="hidden" id="hidden_hh" name="hidden_hh" value="12">
													<input type="hidden" id="cur_hh" name="cur_hh" value="11">
													<input type="hidden" id="hidden_mn" name="hidden_mn" value="44">
													<input type="hidden" id="cur_mn" name="cur_mn" value="48">
													<p>
														<a href="#edit_timestamp" class="save-timestamp hide-if-no-js button">OK</a>
														<a href="#edit_timestamp" class="cancel-timestamp hide-if-no-js button-cancel">Cancel</a>
													</p>
												</fieldset>
											</div>
											<div class="clear"></div>
										</div>
										<div id="major-publishing-actions">
											<div id="delete-action">
												<a class="submitdelete deletion" href="#">Move to Trash</a>
											</div>
											<div id="publishing-action">
												<span class="spinner"></span>
												<input name="original_publish" type="hidden" id="original_publish" value="Publish">
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