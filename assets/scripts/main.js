/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

 (function($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function() {
        // JavaScript to be fired on all pages

        $(document).foundation(); // Foundation JavaScript

        $('.scroll-top-inner').click( function() {
          $('html, body').animate( { scrollTop: 0 }, 500 );
          return false;
        });

      },
      finalize: function() {
        // JavaScript to be fired on all pages, after page specific JS is fired

        var cardList = $("#card-list");

        cardList.submit(function(e){
          e.preventDefault();
          var send_data = $(this).serialize(),
          msgContainer = cardList.parents(".container").find(".msg-container"),
          loadingIcon = cardList.parents(".container").find(".loading");
          msgContainer.hide(0, function(){
            loadingIcon.show();
          });

          $.post(ajaxurl, 'action=add_card&' + send_data, function(data){
            data = JSON.parse(data);
            if (data.success === 1) {
              loadingIcon.fadeOut(500, function(){
                msgContainer.html("<div data-alert='' class='alert-box success'>" + data.duration + "<a href='#'' class='close'>×</a></div>");
                msgContainer.fadeIn();
              });

              setTimeout(function() {
                location.reload();
              }, 1500);

            } else {
              loadingIcon.fadeOut(500, function(){
                msgContainer.html("<div data-alert='' class='alert-box alert'>" + data.error_msg + "<a href='#'' class='close'>×</a></div>");
                msgContainer.fadeIn();
              });
            }
          });
        });


/****************************************************************
*                                                               *
*   OLD Shopping basket functions                                   *
*                                                               *
****************************************************************/

// var basketModal = $("#search-card-modal"),
// basketCardName = $("#s", basketModal),
// submitButton = $("#format-basket", basketModal);

// basketModal.on( "opened.fndtn.reveal", function(){
//   basketCardName.focus();
// });

// submitButton.on("click", function(){
//   var container = $(this).parents(".content");
//   container.find('[data-format-leave="0"]').remove();
//   container.find('[data-format-leave="1"]').removeClass("small-1").addClass("small-2");
//   container.find('[data-format-leave="2"]').toggleClass("hide");

//   // toggle view of tags that one tag below in DOM should be deleted
//   container.find('[data-format-leave="3"]').each(function(){
//     var t = $(this);
//     t.parent().html(t.html());
//   });

//   // container.find('> .row').replaceTag('<tr>', false);
//   // container.find('tr > div').replaceTag('<td>', false);
//   // container.replaceTag('<table>', false);
//   container.parent().find('[data-table]').each(function(){
//     $(this).replaceTag($(this).data('table'), false);
//   });
// });


/****************************************************************
*                                                               *
*   Update expansions select options based on typed card name   *
*                                                               *
****************************************************************/

var newCardModal = $("#add-card-modal"),
newCardForm = $("form", newCardModal),
cardName = $("#name", newCardForm),
cardExpansions = $("#expansion", newCardForm);

newCardModal.on( "opened.fndtn.reveal", function(){
  cardName.focus();
});

cardName.donetyping(function(){
  $.post(ajaxurl, "action=update_form_expansions&name=" + cardName.val(), function(data){
    data = JSON.parse(data);
    cardExpansions.html("");
    if ( data.MKM_response.product instanceof Array ) {
      Object.keys(data.MKM_response.product).map( function(item) {
        cardExpansions.append("<option data-id='" + data.MKM_response.product[item].idProduct + "' value='" + data.MKM_response.product[item].expansion + "'>" + data.MKM_response.product[item].expansion + " - " + data.MKM_response.product[item].name[0].productName + "</option>");
      });
    } else {
      cardExpansions.append("<option data-id='" + data.MKM_response.product.idProduct + "' value='" + data.MKM_response.product.expansion + "'>" + data.MKM_response.product.expansion + "</option>");
    }
  });
});

newCardForm.submit(function(e){
  e.preventDefault();
  var send_data = $(this).serialize();
  $.post(ajaxurl, "action=add_single_card&" + send_data + "&product_id=" + $(":selected", cardExpansions).data("id"), function(data){
    data = JSON.parse(data);
    $(".alert-container", newCardModal).append("<div class='alert-box warning' data-alert>" + data.message + "<a href='#' class='close'>&times;</a></div>");
    $(document).foundation('alert', 'reflow');
  });
});

var postContent = $("form#forum-content");

postContent.submit(function(e){
  e.preventDefault();
  var send_data = $(this).serialize(),
  msgContainer = $(this).parents(".form-container").find(".msg-container");
  $.post(ajaxurl, 'action=update_forum&' + send_data, function(data){
    data = JSON.parse(data);

    msgContainer.fadeOut(500, function(){
      msgContainer.html("<div data-alert='' class='alert-box success'>" + data.value + "<a href='#'' class='close'>×</a></div>");
      msgContainer.fadeIn(500);
    });

    if (data.success === 1) {

      setTimeout(function() {
        location.reload();
      }, 1500);

    }
  });
});

adminEvents = {
  init: function() {

    adminEvents.postDelete();
    adminEvents.postUpdate();
    adminEvents.postSell();
    adminEvents.postInfo();
    adminEvents.postCondition();
    adminEvents.postLanguage();
    adminEvents.postOwner();
    adminEvents.loadMore();
    adminEvents.changeAmount();
    adminEvents.loadSearchedCard();
    adminEvents.buttonNumbersInit();

  },
  postDelete: function() {

    $(".post-delete:not(.bound)").addClass('bound').click(function(e){
      e.preventDefault();
      var t = $(this);
      $.post(ajaxurl, "action=trash_post&post_id=" + t.parents("[data-id]").data("id"), function(data){
        data = JSON.parse(data);
        if (data.success === 1) {
          t.parents("[data-id]").fadeOut();
        } else {
          alert(data);
        }
      });
    });

  },
  postUpdate: function() {

    $(".post-update:not(.bound)").addClass('bound').click(function(e){
      e.preventDefault();
      var t = $(this);
      $.post(ajaxurl, "action=update_post&post_id=" + t.parents("[data-id]").data("id") + "&is_foil=" + t.parents("[data-id]").data("foil"), function(data){
        data = JSON.parse(data);
        if (data.success === 1) {
          t.parents("[data-id]").fadeOut(500, function(){
            var k = $(this);
            // update price field if request was made for basket
            if ( k.context.tagName === "TR" ) {
              k.find('input[name^="price"]').val(data.price);
              k.find('span[data-source^="price"]').html(data.price);
            }
            // update price field if request was made from cards list
            else if ( k.context.tagName === "DIV" ) {
              k.find('.Cena span').html(data.price);
            }
            k.fadeIn(500);
          });
        } else {
          alert(data);
        }
      });
    });

  },
  postSell: function() {

    $(".post-sell:not(.bound)").addClass('bound').click(function(e){
      e.preventDefault();
      var t = $(this);
      $.post(ajaxurl, "action=sell_cards&post_id=" + t.parents("[data-id]").data("id") + "&amount=" +  t.parents("[data-id]").find(".Sprzedane span").html(), function(data){
        data = JSON.parse(data);
        if (data.success === 1) {
          t.parents("[data-id]").fadeOut(500, function(){
            var k = $(this);
            $(".Ilość", k).data("ilosc", data.value).find("span").html(data.ilosc);
            k.fadeIn(500);
          });
        } else {
          t.parents("td").append("<div class='alert-box warning' data-alert>" + data.message + "<a href='#' class='close'>&times;</a></div>");
          $(document).foundation('alert', 'reflow');
        }
      });
    });

  },
  postInfo: function() {

    $(".post-info:not(.bound)").addClass('bound').click(function(e){
      e.preventDefault();
      var t = $(this);
      $.post(ajaxurl, "action=info_cards&post_id=" + t.parents("[data-id]").data("id") + "&is_foil=" + t.parents("[data-id]").data("foil"), function(data){
        data = JSON.parse(data);
      });
    });

  },
  postHide: function() {

    $(".post-hide:not(.bound)").addClass('bound').click(function(e){
      e.preventDefault();
      var t = $(this);
      t.parents('[data-id]').fadeOut(500, function(){
        t.parents('[data-id]').remove();
      });
    });

  },
  postSelect: function( t, data, type ) {

    var currentState = $("span", t).html();

    t.addClass("active").html("<select class='update-" + type + "' id='" + t.parents("[data-id]").data("id") + "'></select>");
    Object.keys(data.value).map( function(item) {
      if ( data.value[item] === currentState ) {
        t.find("select").append("<option value='" + data.value[item] + "' selected='selected'>" + data.value[item] + "</option>");
      } else {
        t.find("select").append("<option value='" + data.value[item] + "'>" + data.value[item] + "</option>");
      }
    });

    var selectChoices = $("#" + t.parents('[data-id]').data('id') );
    selectChoices.on("change", function(){
      $.post(ajaxurl, "action=update_" + type + "&post_id=" + selectChoices.prop("id") + "&value=" + selectChoices.val(), function(data){
        data = JSON.parse(data);
        t.removeClass("active").html("<span>" + data.value + "</span>");
        console.log(type + data.value);
        console.log(t.parents('[data-id]'));
        t.parents('[data-id]').attr( "data-owner", data.value );
      });
    });

  },
  postCondition: function() {

    $(".Stan:not(.bound)").addClass('bound').click(function(e){
      var t = $(this);
      e.preventDefault();

      if ( !t.hasClass("active") ) {
        $.post(ajaxurl, "action=choose_condition", function(data){
          data = JSON.parse(data);
          adminEvents.postSelect( t, data, 'condition');
        });
      }
    });

  },
  postLanguage: function() {

    $(".Język:not(.bound)").addClass('bound').click(function(e){
      var t = $(this);
      e.preventDefault();

      if ( !t.hasClass("active") ) {
        $.post(ajaxurl, "action=choose_language", function(data){
          data = JSON.parse(data);
          adminEvents.postSelect( t, data, 'language');
        });
      }
    });

  },
  postOwner: function() {

    $(".Własność:not(.bound)").addClass('bound').click(function(e){
      var t = $(this);
      e.preventDefault();

      if ( !t.hasClass("active") ) {
        $.post(ajaxurl, "action=choose_owner", function(data){
          data = JSON.parse(data);
          adminEvents.postSelect( t, data, 'owner');
        });
      }
    });

  },
  changeAmount: function() {

    $(".change-amount:not(.bound)").addClass('bound').click(function(e){
      e.preventDefault();
      var t = $(this);
      $.post(ajaxurl, "action=update_quantity&post_id=" + t.parents("[data-id]").data("id") + "&value=" + t.data("step") + "&type=" + t.data("change") + "&previous=" + t.parent().find("span > small").html(), function(data){
        data = JSON.parse(data);
        if (data.success === 1) {
          if (data.quantity === 0 && t.data("change") === "ilosc") {
            t.parents("[data-id]").fadeOut(500);
          } else {
            t.parents("[data-id]").find("[data-" + t.data('change') + "]").attr("data-" + t.data('change'), data.quantity).find("span > small").html(data.quantity);
          }
          if( t.data("change") === "sprzedane" && !( data.quantity === data.prev_quantity && data.quantity === 0 ) ) {
            var ilosc = t.parents("[data-id]").find("[data-ilosc]").find("span > small");
            ilosc.html( parseInt(ilosc.html()) - parseInt(t.data("step")) ) ;
          }
        } else {
          alert(data);
        }
      });
    });

  },
  sumBasket: function() {

    $(".Sprzedane .change-amount:not(.selling-bound)").addClass('selling-bound').click(function(e){
      e.preventDefault();
      var t = $(this),
      // if card was added or removed from basket
      step = parseInt( t.data('step') ),
      // find container with basket summaries
      orderSumContainer = t.parents('.content').find('.order-sum'),
      // seek for parent div of picked card to know where to look for meta values
      cardRow = t.parents('[data-id]'),
      soldAmount = cardRow.find('.sold-amount'),
      price = parseInt( cardRow.find('.Cena > span').html() ),
      owner = cardRow.find('.Własność > span').html(),

      // find cell in basket summaries that has the same ownership as picked card
      ownerField = orderSumContainer.find('[data-owner="' + owner + '"]'),

      // sum all owner fields and form as total basket value
      summaryField = orderSumContainer.find('[data-owner="total"]');

      if ( ownerField.html() !== "" && ownerField.html() !== "0" ) {
        ownerField.html( parseInt( ownerField.html() ) + ( price * step) );
      } else if ( step > 0 ) {
        ownerField.html( ( price * step) );
      } else {
        console.log('probuje pan zrobic ujemny rachunek');
      }

      if ( summaryField.html() !== "" && summaryField.html() !== "0" ) {
        summaryField.html( parseInt( summaryField.html() ) + ( price * step) );
      } else if ( step > 0 ) {
        summaryField.html( ( price * step) );
      } else {
        console.log('probuje pan zrobic ujemny rachunek');
      }

      if ( soldAmount.html() !== "" && soldAmount.html() !== "0" ) {
        soldAmount.html( parseInt( soldAmount.html() ) + step );
      } else if ( step > 0 ) {
        soldAmount.html( step );
      }
    });

  },
  loadMore: function() {
  // load more posts like jquery lazyload

  $(".load-more:not(.bound)").addClass('bound').bind("inview", function(e, b, c, d){
    e.preventDefault();
    var t = $(this),
    args = "&rarity=" + t.data("rarity");
    if ( t.data("paged") ) { args = args + "&paged=" + t.data("paged"); }
    if ( t.data("order") ) { args = args + "&order=" + t.data("order"); }
    if ( t.data("orderby") ) { args = args + "&orderby=" + t.data("orderby"); }
    if ( t.data("meta-key") ) { args = args + "&meta_key=" + t.data("meta-key"); }
    t.append("<i class='ajax-spinner'></i>");
    $.post(ajaxurl, "action=load_posts" + args, function(data) {
      t.find("i").remove();
      try {
        json = JSON.parse(data);
      } catch (exception) {
        json = null;
      }
      if (json) {
        t.addClass("disabled").html(json.message);
      } else {
        t.data("paged", t.data("paged") + 1 ).parents(".content.active").find(".cards-list").append(data);
        adminEvents.postDelete();
        adminEvents.postUpdate();
        adminEvents.postSell();
        adminEvents.postInfo();
        adminEvents.postCondition();
        adminEvents.postLanguage();
        adminEvents.postOwner();
        adminEvents.changeAmount();
        $(document).foundation("tooltip", "reflow");
      }
    });
  });

},
loadSearchedCard: function() {
  // load searched card under searchform in search modal after form is submitted

  $("#search").submit(function(e){
    e.preventDefault();
    var t = $(this),
    cardID = t.find('input[name="card-id"]').val(),
    send_data = $(this).serialize();

    $.post(ajaxurl, "action=load_searched_card&" + send_data, function(data) {
      try {
        json = JSON.parse(data);
      } catch (exception) {
        json = null;
      }
      if (json) {
        t.addClass("disabled").html(json.message);
      } else {
        var resultsContainer = t.parent().find(".cards-list");
        resultsContainer.append(data);

        adminEvents.postDelete();
        adminEvents.postUpdate();
        adminEvents.postSell();
        adminEvents.postInfo();
        adminEvents.postCondition();
        adminEvents.postLanguage();
        adminEvents.postOwner();
        adminEvents.changeAmount();
        adminEvents.sumBasket();
        adminEvents.postHide();
        $(document).foundation("tooltip", "reflow");
      }
    });
  });
},
btnNrArgs: {
  button: $('.button-number:not(.bound)'),
  inputNumber: $('.input-number:not(.bound)'),

},
buttonNumbersInit: function() {

  adminEvents.buttonNumbersArgsSetup();
  adminEvents.buttonNumbersSetup();
  adminEvents.buttonNumberFocusIn();
  adminEvents.buttonNumberChange();
  adminEvents.buttonNumbersKeyDown();

},
buttonNumbersArgsSetup: function() {
  adminEvents.btnNrArgs = {
    button: $('.button-number:not(.bound)'),
    inputNumber: $('.input-number:not(.bound)'),
  };
},
buttonNumbersSetup: function() {

  adminEvents.btnNrArgs.button.addClass('bound').click(function(e){
    e.preventDefault();

    var fieldName = $(this).attr('data-field');
    var type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
      if(type === 'minus') {
        var minValue = parseInt(input.attr('min'));
        if(!minValue && minValue !== 0) { minValue = 1; }
        if(currentVal > minValue) {
          input.val(currentVal - 1).change();
        }
        if(parseInt(input.val()) === minValue) {
          $(this).attr('disabled', true);
        }

      } else if(type === 'plus') {
        var maxValue = parseInt(input.attr('max'));
        if(!maxValue && maxValue !== 0) { maxValue = 9999999999999; }
        if(currentVal < maxValue) {
          input.val(currentVal + 1).change();
        }
        if(parseInt(input.val()) === maxValue) {
          $(this).attr('disabled', true);
        }

      }
    } else {
      input.val(0);
    }

    if ( input.data('target') && $('[data-source="' + input.data("target") + '"]') ) {
      $('[data-source="' + input.data("target") + '"]').html(input.val());
    }

  });

},
buttonNumberFocusIn: function() {

  adminEvents.btnNrArgs.inputNumber.addClass('bound').focusin(function(){
   $(this).data('oldValue', $(this).val());
 });

},
buttonNumberChange: function() {

  adminEvents.btnNrArgs.inputNumber.change(function() {

    var minValue =  parseInt($(this).attr('min'));
    var maxValue =  parseInt($(this).attr('max'));
    if(!minValue && minValue !== 0) { minValue = 1; }
    if(!maxValue && maxValue !== 0) { maxValue = 9999999999999; }
    var valueCurrent = parseInt($(this).val());

    var name = $(this).attr('name');
    if(valueCurrent >= minValue) {
      $(".button-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled');
    } else {
      alert('Sorry, the minimum value was reached');
      $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
      $(".button-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled');
    } else {
      alert('Sorry, the maximum value was reached');
      $(this).val($(this).data('oldValue'));
    }


  });

},
buttonNumbersKeyDown: function() {

  adminEvents.btnNrArgs.inputNumber.keydown(function (e) {
    // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
      // Allow: Ctrl+A
      (e.keyCode === 65 && e.ctrlKey === true) ||
      // Allow: home, end, left, right
      (e.keyCode >= 35 && e.keyCode <= 39)) {
        // let it happen, don't do anything
      return;
    }
    // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
      e.preventDefault();
    }
  });

}

};

adminEvents.init();

/****************************************************************
*                                                               *
*   Shopping basket functions                                   *
*                                                               *
****************************************************************/

var basket = {
  args: {

    basketModal:        $("#basket-modal"),
    basketMessages:     $("#basket-modal .msg-container"),
    basketCardName:     $("#s"),
    basketSearchForm:   $("#search"),
    basketCardsList:    $("#basket-table"),
    basketSums: {
      team:                 $("span.total-sum.team"),
      leszek:               $("span.total-sum.leszek"),
      slawek:               $("span.total-sum.slawek"),
      total:                $("span.total-sum.total"),
    },
    basketStatus:       $("#basket-status"),
    updateStatus:       $(".update-status"),
    saveCart:           $("#save-basket"),
    removeCart:         $("#remove-basket"),
    basketsList:        $("#baskets-drop"),
  },
  init: function() {

    basket.args.basketModal.on("opened.fndtn.reveal", function(){
      basket.args.basketCardName.focus();
    });

    basket.searchForm();
    basket.bindCounters();
    basket.updateShippingCost();
    basket.emailFriendly();
    basket.resetBasketButton();
    basket.updateStatus();
    basket.saveCart();
    basket.loadCart();
    basket.removeCart();

  },
  searchForm: function() {

    basket.args.basketSearchForm.submit(function(e){

      e.preventDefault();
      var t = $(this),
      send_data = $(this).serialize();

      $.post(ajaxurl, "action=add_to_basket&" + send_data, function(data) {
        try {
          json = JSON.parse(data);
        } catch (exception) {
          json = null;
        }
        if (json) {
          t.addClass("disabled").html(json.message);
        } else {
          basket.args.basketCardsList.find("tbody.list").append(data);

          adminEvents.postUpdate();
          adminEvents.postOwner();
          adminEvents.buttonNumbersInit();
          basket.bindCounters();
        }
      });

    });

  },
  updateShippingCost: function() {
    var cost = parseInt( basket.args.basketModal.find("input[name='quant-shipping-cost']").val() );
    basket.args.basketModal.find(".shipping-cost").html( cost );
  },
  updateStatus: function() {

    basket.args.updateStatus.each(function(){

      var t = $(this);

     t.click(function() {

        if ( confirm( "Confirm change of cart status" ) ) {

          var basketId = t.data("basket-id"),
          status = t.data('status');

          var callParams = {
            'action'    : 'update_basket_status',
            'basket_id' : basketId,
            'status'    : status
          };

          var loadCartRequest = $.ajax({
            type: 'POST',
            url: ajaxurl,
            data: callParams,
            success: function(response) {
              data = JSON.parse(response);
              basket.args.basketMessages.fadeOut(500, function(){
                basket.args.basketMessages.html("<div data-alert='' class='alert-box success'>" + data.value + "<a href='#'' class='close'>×</a></div>");
                basket.args.basketMessages.fadeIn(500);
              });

              t.addClass("hide");

            },
            error: function(response) {
              alert( "error" );
              basket.args.basketMessages.fadeOut(500, function(){
                basket.args.basketMessages.html("<div data-alert='' class='alert-box error'>" + data.value + "<a href='#'' class='close'>×</a></div>");
                basket.args.basketMessages.fadeIn(500);
              });
            },
            fail: function() {
              alert( "error" );
              basket.args.basketMessages.fadeOut(500, function(){
                basket.args.basketMessages.html("<div data-alert='' class='alert-box error'>" + data.value + "<a href='#'' class='close'>×</a></div>");
                basket.args.basketMessages.fadeIn(500);
              });
            },
          });

        }

      });

    });

  },
  setStatus: function(basketId) {

    var callParams = {
      'action': 'get_basket_status',
      'basket_id': basketId,
    };

    var getBasketStatus = $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: callParams,
      success: function(response) {
        data = JSON.parse(response);

        // update span with status label
        basket.args.basketStatus.html(data.statusString);
        basket.args.basketStatus.data("status", data.status);
        // hide all update status buttons
        basket.args.updateStatus.addClass("hide");
        if (data.status === "preorder") {
          basket.args.updateStatus.filter("[data-status='shipped']").removeClass("hide");
        }
        else if (data.status === "shipped") {
          basket.args.updateStatus.filter("[data-status='billed']").removeClass("hide");
        }
      },
      error: function(response) {
        alert( "error" );
      },
      fail: function() {
        alert( "error" );
      },
      always: function() {
      }
    });
  },
  saveCart: function() {

    basket.args.saveCart.click(function() {

      var cards = basket.args.basketCardsList.find("[data-id]"),
      basketId = basket.args.basketCardsList.data("basket-id"),
      basketCardsList = {},
      discount = parseInt( basket.args.basketCardsList.find(".discount").html() ),
      shippingCost = parseInt( basket.args.basketCardsList.find(".shipping-cost").html() ),
      totalSum = parseInt( basket.args.basketCardsList.find(".total-sum").html() ),
      teamSum = parseInt( basket.args.basketSums.team.html() ),
      leszekSum = parseInt( basket.args.basketSums.leszek.html() ),
      slawekSum = parseInt( basket.args.basketSums.slawek.html() ),
      basketName = $("#basket-name").val();

      cards.each(function(i){
        var c = $(this),
        card = {};
        card.cardId = c.data("id");
        card.amount = parseInt( c.find("[name^='quant']").val() );
        card.price = parseInt( c.find("[data-source^='price[']").html() );
        basketCardsList["card-" + i] = card;
      });

      var objBasketCardsList = $.extend({}, basketCardsList);

      var callParams = {
        'action': 'add_basket',
        'basket_name': basketName,
        'discount': discount,
        'shipping_cost': shippingCost,
        'total_sum': totalSum,
        'team_sum' : teamSum,
        'leszek_sum' : leszekSum,
        'slawek_sum' : slawekSum,
        'cards': basketCardsList,
        'basket_status': basket.args.basketStatus.data("status")
      };

      console.log(callParams);

      if (basketId) {
        callParams.basket_id = basketId;
      }

      var addCartRequest = $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: callParams,
        success: function(response) {
          data = JSON.parse(response);
          basket.args.basketMessages.fadeOut(500, function(){
            basket.args.basketMessages.html("<div data-alert='' class='alert-box success'>" + data.value + "<a href='#'' class='close'>×</a></div>");
            basket.args.basketMessages.fadeIn(500);
          });
        },
        error: function(response) {
          alert( "error" );
          basket.args.basketMessages.fadeOut(500, function(){
            basket.args.basketMessages.html("<div data-alert='' class='alert-box error'>" + data.value + "<a href='#'' class='close'>×</a></div>");
            basket.args.basketMessages.fadeIn(500);
          });
        },
        fail: function() {
          alert( "error" );
          basket.args.basketMessages.fadeOut(500, function(){
            basket.args.basketMessages.html("<div data-alert='' class='alert-box error'>" + data.value + "<a href='#'' class='close'>×</a></div>");
            basket.args.basketMessages.fadeIn(500);
          });
        },
        always: function() {
          alert( "complete" );
        }
      });

    });

  },
  loadCart: function() {
    basket.args.basketsList.find("li a").each(function(){
      $(this).click(function(e){
        e.preventDefault();

      // clear all basket's data before loading a new one
      basket.resetBasket();

      // add loaded cart's id to basket
      basket.args.basketCardsList.data("basket-id", $(this).data("basket-id"));
      basket.args.updateStatus.data("basket-id", $(this).data("basket-id"));
      basket.args.removeCart.data("basket-id", $(this).data("basket-id"));

      var basketId = $(this).data("basket-id"),
      callParams = {
        'action': 'load_basket',
        'basket_id': basketId,
      };

      var loadCartRequest = $.ajax({
        type: 'POST',
        url: ajaxurl,
        data: callParams,
        success: function(response) {

          basket.args.basketCardsList.find("tbody.list").append(response);

          adminEvents.postUpdate();
          adminEvents.postOwner();
          adminEvents.postHide();
          adminEvents.buttonNumbersInit();
          basket.discountUpdate(basketId);
          basket.bindCounters();
          basket.countSums();
          $(document).foundation("tooltip", "reflow");
        },
        error: function(response) {
          alert( "error" );
        },
        fail: function() {
          alert( "error" );
        },
        always: function() {
          alert( "complete" );
        }
      });

      // update status
      basket.setStatus(basketId);
      basket.args.removeCart.removeClass("hide");

    });
    });

  },
  removeCart: function() {
    basket.args.removeCart.click(function(){

      var t = $(this);

      if ( confirm( "Are you sure you want to remove?" ) ) {

        var callParams = {
          'action': 'remove_basket',
          'basket_id': $(this).data("basket-id"),
        };

        var loadCartRequest = $.ajax({
          type: 'POST',
          url: ajaxurl,
          data: callParams,
          success: function(response) {

            data = JSON.parse(response);
            console.log(data);
            basket.args.basketMessages.fadeOut(500, function(){
              basket.args.basketMessages.html("<div data-alert='' class='alert-box error'>" + data.value + "<a href='#'' class='close'>×</a></div>");
              basket.args.basketMessages.fadeIn(500);
            });

            t.addClass("hide");

            basket.resetBasket();

          },
          error: function(response) {
            basket.args.basketMessages.fadeOut(500, function(){
              basket.args.basketMessages.html("<div data-alert='' class='alert-box error'>" + data.value + "<a href='#'' class='close'>×</a></div>");
              basket.args.basketMessages.fadeIn(500);
            });
          },
          fail: function() {
            basket.args.basketMessages.fadeOut(500, function(){
              basket.args.basketMessages.html("<div data-alert='' class='alert-box error'>" + data.value + "<a href='#'' class='close'>×</a></div>");
              basket.args.basketMessages.fadeIn(500);
            });
          },
          always: function() {
          }
        });

      }

    });
  },
  updateCart: function() {

  },
  bindCounters: function() {

    basket.args.basketModal.find(".button-number:not(.counting)").addClass("counting").click(function(e){
      e.preventDefault();
      basket.countSums();
      basket.updateShippingCost();
    });

  },
  discountUpdate: function(basketId) {

    var callParams = {
      'action': 'get_basket_discount',
      'basket_id': basketId,
    };

    var loadCartRequest = $.ajax({
      type: 'POST',
      url: ajaxurl,
      data: callParams,
      success: function(response) {

        data = JSON.parse(response);
        basket.args.basketModal.find("input[name='quant-discount']").val(data.discount);
        basket.args.basketModal.find("input[name='quant-shipping-cost']").val(data.shipping);
        // basket.args.basketModal.find("select[name='basket-status']").val(data.status);
      },
      error: function(response) {
        alert( "error" );
      },
      fail: function() {
        alert( "error" );
      },
      always: function() {
        alert( "complete" );
      }
    });

  },
  countSums: function() {

    // var cardsList = basket.args.basketCardsList.find("[data-id]"),
    var teamCards = {
      list: basket.args.basketCardsList.find("[data-owner='Team']"),
      sum: 0
    },
    leszekCards = {
      list: basket.args.basketCardsList.find("[data-owner='Leszek']"),
      sum: 0
    },
    slawekCards = {
      list: basket.args.basketCardsList.find("[data-owner='Sławek']"),
      sum: 0
    },
    discount = parseInt( basket.args.basketModal.find("input[name='quant-discount']").val() ),
    shippingCost = parseInt( basket.args.basketModal.find("input[name='quant-shipping-cost']").val() );

    // discount = ( discount === 0 ) ? 0 : discount;

    // count partial sums by ownership
    teamCards.sum = basket.countPartialSum( teamCards.list );
    leszekCards.sum = basket.countPartialSum( leszekCards.list );
    slawekCards.sum = basket.countPartialSum( slawekCards.list );

    // sum all partial sum to overall basket value
    var basketSum = teamCards.sum + leszekCards.sum + slawekCards.sum;

    // count partial percentage share in basket by ownership

    teamCards.pct = teamCards.sum / basketSum;
    leszekCards.pct = leszekCards.sum / basketSum;
    slawekCards.pct = slawekCards.sum / basketSum;

    // update partial sums by discount
    teamCards.sum = teamCards.sum- (discount * teamCards.pct);
    leszekCards.sum = leszekCards.sum - (discount * leszekCards.pct) + shippingCost;
    slawekCards.sum = slawekCards.sum - (discount * slawekCards.pct);

    basket.args.basketSums.team.html( Math.round(teamCards.sum) );
    basket.args.basketSums.leszek.html( Math.round(leszekCards.sum) );
    basket.args.basketSums.slawek.html( Math.round(slawekCards.sum) );
    basket.args.basketSums.total.html( teamCards.sum + leszekCards.sum + slawekCards.sum );

  },
  countPartialSum: function( el ) {

    sum = 0;

    el.each(function(){
      var c = $(this),
      price = c.find("input[name^='price']").val(),
      amount = c.find("input[name^='quant']").val();
      sum += price*amount;
    });

    return sum;

  },
  emailFriendly: function() {

    basket.args.basketModal.find("#email-friendly").click(function(){

      var EmailToggleElements = $("#basket-modal [data-email-swap]");
      EmailToggleElements.toggle();

    });

  },
  resetBasket: function() {

    basket.args.basketCardsList.find("tbody.list").html("");
    basket.countSums();

  },
  resetBasketButton: function() {
    basket.args.basketModal.find("#reset-basket:not(.bound)").addClass('bound').click(function(){

      if ( confirm( "Are you sure you want to reset?" ) ) {

        basket.resetBasket();

      }

    });

  }

};

basket.init();

}
},
    // Home page
    'home': {
      init: function() {
        // JavaScript to be fired on the home page

      },
      finalize: function() {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function() {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function(func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function() {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function(i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
