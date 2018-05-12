var gp4Loading = false;

jQuery('#gp4-form-button').on('click', function(e) {
    e.preventDefault();

    console.log('start confirm');

    // フォームの非表示と結果表示
    jQuery('#gp4-pay-form').attr('style', 'display:none;');
    jQuery('#gp4-pay-result').html(
        '<div class="gp4_pay_confirm">' +
            '<div id="loading"><img class="gp4_ajax_loader" src="loader.gif" style="display:none;"></div>' +
            '<div id="main-contents">' +
                '<dl>' +
                    '<dt>カード番号：</dt>' +
                    '<dd>' + jQuery('#gp4-pay-form [name=c_number]').val() + '</dd>' +
                    '<dt>有効期限：</dt>' +
                    '<dd>' + jQuery('#gp4-pay-form [name=exp_year]').val() + '/' + jQuery('#gp4-pay-form [name=exp_month]').val() + '</dd>' +
                    '<dt>セキュリティチェックコード</dt>' +
                    '<dd>●●●</dd>' +
                    '<dt>カード保有者名</dt>' +
                    '<dd>' + jQuery('#gp4-pay-form [name=name]').val() + '</dd>' +
                    '<dt>支払い料金</dt>' +
                    '<dd>' + jQuery('#gp4-pay-form [name=amount]').val() + '円</dd>' +
                '</dl>' +
                '<input type="submit" id="gp4-pay-modify" value="修正する" class="btn gp4_submit">' +
                '<span>&nbsp;</span>' +
                '<input type="submit" id="gp4-pay-confirm" value="確定する" class="btn gp4_submit">' +
            '</div>' +
        '</div>'
    );

    jQuery('#gp4-pay-modify').on('click', function (e) {
        e.preventDefault();

        console.log('start modify');

        // 修正ボタン押下時は、結果画面を削除してフォームに戻る
        jQuery('#gp4-pay-form').attr('style', 'display:block;');
        jQuery('.gp4_pay_confirm').remove();
    });

    jQuery('#gp4-pay-confirm').on('click', function (e) {
        e.preventDefault();

        // 確定ボタン押下時は、ローダーを有効にしてボタンを無効化
        jQuery('.gp4_ajax_loader').attr('style', 'display:block');
        jQuery('input').attr('disabled', 'disabled');

        console.log('start ajax');
        var data = {
            'user_id': jQuery('#gp4-pay-form [name=user_id]').val(),
            'test_mode': jQuery('#gp4-pay-form [name=test_mode]').val(),
            'c_number': jQuery('#gp4-pay-form [name=c_number]').val(),
            'exp_year': jQuery('#gp4-pay-form [name=exp_year]').val(),
            'exp_month': jQuery('#gp4-pay-form [name=exp_month]').val(),
            'cvc': jQuery('#gp4-pay-form [name=cvc]').val(),
            'name': jQuery('#gp4-pay-form [name=name]').val(),
            'amount': jQuery('#gp4-pay-form [name=amount]').val()
        };
        jQuery.ajax({
            'type': 'POST',
            'url': '/wp-json/gpay/1/pay',
            'contentType': 'application/json',
            'data': JSON.stringify(data)
        }).done( function( response, textStatus, jqXHR ) {
            // 送金完了画面
            jQuery('#gp4-pay-form').remove();
            jQuery('.gp4_pay_confirm').remove();
            jQuery('#gp4-pay-result').html(
                '<div class="gp4_pay_success">送金が完了しました。</div>'
            );


        }).fail( function( jqXHR, textStatus, errorThrown ) {
            // 一旦アラート出す
            alert('問題が発生しました！\n' + jqXHR);
            console.log(jqXHR);
            jQuery('input').attr('disabled', 'null');
        }).always( function( data_or_jqXHR, textStatus, jqXHR_or_errorThrown ) {
            gp4Loading = false;
        });
    });
});

