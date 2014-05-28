/*  Author: Grapheme Group
 *  http://grapheme.ru/
 */

$(function(){
	$("#lot-in-shop").click(function(){
		$("#lot-properties").slideDown(500);
		$(".lot-properties-in-auction").addClass('hidden');
		$(".lot-properties-in-shop").removeClass('hidden');
	});
	$("#lot-in-auction").click(function(){
		$("#lot-properties").slideDown(500);
		$(".lot-properties-in-shop").addClass('hidden');
		$(".lot-properties-in-auction").removeClass('hidden');
	});
});

function runFormValidation(){
	
	var RegisterNewProduct = $("#request-product-form").validate({
		rules:{
			title: {required : true},
		},
		messages : {
			title : {required : 'Укажите название продукта'},
		},
		errorPlacement : function(error, element){error.insertAfter(element.parent());},
		submitHandler: function(form) {
			var options = {target: null,dataType:'json',type:'post'};
			options.beforeSubmit = function(formData,jqForm,options){
				$(form).find('.btn-form-submit').elementDisabled(true);
			},
			options.success = function(response,status,xhr,jqForm){
				$(form).find('.btn-form-submit').elementDisabled(false);
				if(response.status){
					BASIC.inputChanged = false;
					$("#new-product-form").slideUp(500,function(){
						$("#new-product-response-text").html(response.responseText);
						$("#new-product-other-actions").show();
					});
				}else{
					showMessage.constructor(response.responseText,response.responseErrorText);
					showMessage.smallError();
				}
			}
			$(form).ajaxSubmit(options);
		}
	});
	
	var RegisterLot = $("#register-lot-form").validate({
		ignore: ":hidden",
		rules:{
			title: {required : true},
			type_lot: {required : true},
			quantity: {required : true},
			shop_price: {required : true},
			start_price: {required : true},
			auction_price: {required : true},
		},
		messages : {
			title : {required : 'Введите название лота'},
			type_lot : {required : 'Введите cпособ продажи'},
			quantity : {required : 'Введите количество'},
			shop_price : {required : 'Введите цену продажи'},
			start_price : {required : 'Введите начальную цену'},
			auction_price : {required : 'Введите цену'},
		},
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		},
		submitHandler: function(form) {
			var options = {target: null,dataType:'json',type:'post'};
			options.beforeSubmit = function(formData,jqForm,options){
				$(form).find('button[type="submit"]').elementDisabled(true);
			},
			options.success = function(response,status,xhr,jqForm){
				if(response.status){
					BASIC.inputChanged = false;
					$("#div-register-lot-form").slideUp(500,function(){
						$("#register-lot-response-text").html(response.responseText);
						$("#register-lot-other-actions").show();
					});
				}else{
					$(form).find('button[type="submit"]').elementDisabled(false);
					showMessage.constructor(response.responseText,response.responseErrorText);
					showMessage.smallError();
				}
			}
			$(form).ajaxSubmit(options);
		}
	});
	var RegisterLotSearchProducts = $("#search-product-form").validate({
		rules:{
			product_name: {required : true},
		},
		messages : {
			product_name : {required : 'Введите название товарной позиции'},
		},
		errorPlacement : function(error, element) {
			error.insertAfter(element.parent());
		},
		submitHandler: function(form) {
			var options = {target: null,dataType:'json',type:'post'};
			options.beforeSubmit = function(formData,jqForm,options){
				$(form).find('button[type="submit"]').elementDisabled(true);
			},
			options.success = function(response,status,xhr,jqForm){
				$(form).find('button[type="submit"]').elementDisabled(false);
				if(response.status){
					if(response.found){
						$("#register-lot-form-search-response").hide();
						$("#register-lot-form-search").slideUp(500,function(){
							$("#register-lot-form-search-response").html(response.responseText).slideDown(500);
							$(".register-lot-choice-product").on('click',function(){
								$("#register-lot-product-id").val($(this).attr('data-product'));
								$(this).parents('.pop-item-action').remove();
								$("#register-lot-form-search-response").find(".choise-lot-remove").remove();
								$("#register-lot-form-search-response").find(".choise-lot-li-hide[data-product != "+$(this).attr('data-product')+" ]").remove();
								$("#register-lot-properties").slideDown(500);
							});
							$("#show-choise-lot-form").on('click',function(){
								$("#register-lot-form-search-response").slideUp(500,function(){
									$("#register-lot-form-search-response").html('');
									$("#register-lot-form-search").slideDown(500);
								});
							});
						});
					}else{
						$("#register-lot-form-search-response").hide().html(response.responseText).slideDown(500);
					}
				}else{
					showMessage.constructor(response.responseText,response.responseErrorText);
					showMessage.smallError();
				}
			}
			$(form).ajaxSubmit(options);
		}
	});
};