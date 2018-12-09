var a4nLoading = false;

jQuery('#a4n_pay_credit').on('click', function(e) {
    e.preventDefault();
    // フォームの内容を追加
    jQuery('#a4n_pay_select_howtopay').attr('style', 'display:none;');
    jQuery('#a4n-pay-form').html(
        jQuery('#a4n-pay-form').html +
        '<p class="a4n_cardnumber_row"><label class="a4n_cardnumber_row__label">カード番号：</label><input type="text" id="a4n-c-number" name="c_number" class="a4n_cardnumber_row__input"></p>' +
        '<p class="a4n_exp_row"><label class="a4n_exp_row__label">有効期限：</label><input type="text" id="a4n-exp-year" name="exp_year" class="a4n_exp_row__input--year"><span> / </span><input type="text" id="a4n-exp-month" name="exp_month" class="a4n_exp_row__input--month"></p>' +
        '<p class="a4n_cvc_row"><label class="a4n_cvc_row__label">セキュリティキー：</label><input type="text" id="a4n-cvc" name="cvc" class="a4n_cvc_row__input"></p>' +
        '<p class="a4n_name_row"><label class="a4n_name_row__label">カード名義人：</label><input type="text" id="a4n-name" name="name" class="a4n_name_row__input"></p>' +
        '<p class="a4n_amount_row"><label class="a4n_amount_row__label">料金：</label><input type="text" id="a4n-amount" name="amount" class="a4n_amount_row__input"></p>' +
        '<input type="submit" id="a4n-form-button" value="送信" class="btn a4n_submit">'
    );

    jQuery('#a4n-form-button').on('click', function(e) {
        e.preventDefault();

        console.log('start confirm');

        // フォームの非表示と結果表示
        jQuery('#a4n-pay-form').attr('style', 'display:none;');
        jQuery('#a4n-pay-result').html(
            '<div class="a4n_pay_confirm">' +
                '<div id="loading"><img class="a4n_ajax_loader" src="loader.gif" style="display:none;"></div>' +
                '<div id="main-contents">' +
                    '<dl>' +
                        '<dt>カード番号：</dt>' +
                        '<dd>' + jQuery('#a4n-pay-form [name=c_number]').val() + '</dd>' +
                        '<dt>有効期限：</dt>' +
                        '<dd>' + jQuery('#a4n-pay-form [name=exp_year]').val() + '/' + jQuery('#a4n-pay-form [name=exp_month]').val() + '</dd>' +
                        '<dt>セキュリティチェックコード</dt>' +
                        '<dd>●●●</dd>' +
                        '<dt>カード保有者名</dt>' +
                        '<dd>' + jQuery('#a4n-pay-form [name=name]').val() + '</dd>' +
                        '<dt>支払い料金</dt>' +
                        '<dd>' + jQuery('#a4n-pay-form [name=amount]').val() + '円</dd>' +
                    '</dl>' +
                    '<input type="submit" id="a4n-pay-modify" value="修正する" class="btn a4n_submit">' +
                    '<span>&nbsp;</span>' +
                    '<input type="submit" id="a4n-pay-confirm" value="確定する" class="btn a4n_submit">' +
                '</div>' +
            '</div>'
        );

        jQuery('#a4n-pay-modify').on('click', function (e) {
            e.preventDefault();

            console.log('start modify');

            // 修正ボタン押下時は、結果画面を削除してフォームに戻る
            jQuery('#a4n-pay-form').attr('style', 'display:block;');
            jQuery('.a4n_pay_confirm').remove();
        });

        jQuery('#a4n-pay-confirm').on('click', function (e) {
            e.preventDefault();

            // 確定ボタン押下時は、ローダーを有効にしてボタンを無効化
            jQuery('.a4n_ajax_loader').attr('style', 'display:block');
            jQuery('input').attr('disabled', 'disabled');

            console.log('start ajax');
            var data = {
                'user_id': jQuery('#a4n-pay-form [name=user_id]').val(),
                'test_mode': jQuery('#a4n-pay-form [name=test_mode]').val(),
                'c_number': jQuery('#a4n-pay-form [name=c_number]').val(),
                'exp_year': jQuery('#a4n-pay-form [name=exp_year]').val(),
                'exp_month': jQuery('#a4n-pay-form [name=exp_month]').val(),
                'cvc': jQuery('#a4n-pay-form [name=cvc]').val(),
                'name': jQuery('#a4n-pay-form [name=name]').val(),
                'amount': jQuery('#a4n-pay-form [name=amount]').val()
            };
            jQuery.ajax({
                'type': 'POST',
                'url': '/wp-json/gpay/1/pay',
                'contentType': 'application/json',
                'data': JSON.stringify(data)
            }).done( function( response, textStatus, jqXHR ) {
                // 送金完了画面
                jQuery('#a4n-pay-form').remove();
                jQuery('.a4n_pay_confirm').remove();
                jQuery('#a4n-pay-result').html(
                    '<div class="a4n_pay_success">送金が完了しました。</div>'
                );


            }).fail( function( jqXHR, textStatus, errorThrown ) {
                // 一旦アラート出す
                alert('問題が発生しました！\n' + jqXHR);
                console.log(jqXHR);
                jQuery('input').attr('disabled', 'null');
            }).always( function( data_or_jqXHR, textStatus, jqXHR_or_errorThrown ) {
                a4nLoading = false;
            });
        });
    });
});

jQuery('#a4n_pay_depositment').on('click', function(e) {
    e.preventDefault();

    // フォームの内容を追加
    jQuery('#a4n_pay_select_howtopay').attr('style', 'display:none;');
    jQuery('#a4n-pay-form').html(
        jQuery('#a4n-pay-form').html +
        '<p class="a4n_email"><label class="a4n_email__label">メールアドレス：</label><input type="text" id="a4n-email" name="email" class="a4n_email__input"></p>' +
        '<input type="submit" id="a4n-form-button" value="送信" class="btn a4n_submit" required>'
    );
    jQuery('#a4n-form-button').on('click', function(e) {
        e.preventDefault();

        // TODO Validationをつける！required効かない場合。

        jQuery('#a4n-pay-form').attr('style', 'display:none;');
        var data = {
            'user_id': jQuery('#a4n-pay-form [name=user_id]').val(),
            'test_mode': jQuery('#a4n-pay-form [name=test_mode]').val(),
            'email': jQuery('#a4n-pay-form [name=email]').val()
        };

        jQuery.ajax({
            'type': 'POST',
            'url': '/wp-json/gpay/1/pay',
            'contentType': 'application/json',
            'data': JSON.stringify(data)
        }).done( function( response, textStatus, jqXHR ) {
            // 送金完了画面
            jQuery('#a4n-pay-form').remove();
            jQuery('.a4n_pay_confirm').remove();
            jQuery('#a4n-pay-result').html(
                '<div class="a4n_pay_success">ご入力いただいたメールアドレスに振込情報を送信いたします。<br />'+
                'メールの到着まで5分程度お待ちください。<br /><br />' +
                'もし、メールアドレスが間違っていた場合、メールが届かないため、再度入力してください。</div>'
            );
        }).fail( function( jqXHR, textStatus, errorThrown ) {
            // 一旦アラート出す
            alert('問題が発生しました！\n' + jqXHR);
            console.log(jqXHR);
            jQuery('input').attr('disabled', 'null');
        }).always( function( data_or_jqXHR, textStatus, jqXHR_or_errorThrown ) {
            a4nLoading = false;
        });
    });
});


jQuery('#a4n_checkout_deopsitment').on()('click', function(e){
    e.preventDefault();

    jQuery('#a4n-pay-form').attr('style', 'display:none;');
    var data = {
        'user_id': jQuery('#a4n-pay-form [name=user_id]').val(),
        'test_mode': jQuery('#a4n-pay-form [name=test_mode]').val(),
        'email': jQuery('#a4n-pay-form [name=email]').val()
        'token': jQuery('#a4n-pay-form [name=payjp-token]').val()
    };
    jQuery.ajax({
        'type': 'POST',
        'url': '/wp-json/gpay/1/pay',
        'contentType': 'application/json',
        'data': JSON.stringify(data)
    }).done( function( response, textStatus, jqXHR ) {
        // 送金完了画面
        jQuery('#a4n-pay-form').remove();
        jQuery('.a4n_pay_confirm').remove();
        jQuery('#a4n-pay-result').html(
            '<div class="a4n_pay_success">ただいま決済をしております。<br />'+
            'メールの到着までしばらくお待ちください。<br /><br />' +
            'もし、メールアドレスが間違っていた場合、メールが届かないため、再度入力してください。</div>'
        );
    }).fail( function( jqXHR, textStatus, errorThrown ) {
        // 一旦アラート出す
        alert('問題が発生しました！\n' + jqXHR);
        console.log(jqXHR);
        jQuery('input').attr('disabled', 'null');
    }).always( function( data_or_jqXHR, textStatus, jqXHR_or_errorThrown ) {
        a4nLoading = false;
    });
}
