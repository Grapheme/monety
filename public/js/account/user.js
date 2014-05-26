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
	
	var RegisterLot = $("#register-lot-form").validate({
		rules:{
			login: {required : true, email : true},
			password : {required : true, minlength : 6},
		},
		messages : {
			login : {required : 'Введите Ваш адрес электронной почты',email : 'Введите правильный адрес электронной почты'},
			password : {required : 'Введите пароль',minlength : 'Минимальная длина пароля 6 символа'},
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
					BASIC.RedirectTO(response.redirect);
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
						$("#register-lot-form-search").slideUp(500,function(){
							$("#register-lot-form-search-response").html(response.responseText);
							$(".register-lot-choice-product").on('click',function(){
								$("#register-lot-product-id").val($(this).attr('data-product'));
								$("#register-lot-form-search-response").slideUp(500,function(){
									$("#register-lot-properties").show();
								});
							});
						});
					}else{
						$("#register-lot-form-search-response").html(response.responseText);
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