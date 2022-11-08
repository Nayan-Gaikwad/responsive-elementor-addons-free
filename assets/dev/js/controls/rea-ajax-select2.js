(function ($) {
  $(document).on("rea_ajax_select2_init", function (event, obj) {
    var ID = "#elementor-control-default-" + obj.data._cid;
    setTimeout(function () {
      var IDSelect2 = $(ID).select2({
        minimumInputLength: 3,
        ajax: {
          url:
            rea_ajax_select2_localize.ajaxurl +
            "?action=rea_ajax_select2_search_post&post_type=" +
            obj.data.source_type +
            "&source_name=" +
            obj.data.source_name,
          dataType: "json",
        },
        initSelection: function (element, callback) {
          if (!obj.multiple) {
            callback({ id: "", text: rea_ajax_select2_localize.search_text });
          } else {
            callback({ id: "", text: "" });
          }
          var ids = [];
          if (!Array.isArray(obj.currentID) && "" != obj.currentID) {
            ids = [obj.currentID];
          } else if (Array.isArray(obj.currentID)) {
            ids = obj.currentID.filter(function (el) {
              return null != el;
            });
          }

          if (ids.length > 0) {
            var label = $(
              "label[for='elementor-control-default-" + obj.data._cid + "']"
            );
            label.after(
              '<span class="elementor-control-spinner">&nbsp;<i class="eicon-spinner eicon-animation-spin"></i>&nbsp;</span>'
            );
            $.ajax({
              method: "POST",
              url:
                rea_ajax_select2_localize.ajaxurl +
                "?action=rea_ajax_select2_get_title",
              data: {
                post_type: obj.data.source_type,
                source_name: obj.data.source_name,
                id: ids,
              },
            }).done(function (response) {
              if (
                response.success &&
                "undefined" !== typeof response.data.results
              ) {
                let options = "";
                ids.forEach(function (item, index) {
                  if ("undefined" !== typeof response.data.results[item]) {
                    const key = item;
                    const value = response.data.results[item];
                    options += `<option selected="selected" value="${key}">${value}</option>`;
                  }
                });

                element.append(options);
              }
              label.siblings(".elementor-control-spinner").remove();
            });
          }
        },
      });

      //Manual Sorting : Select2 drag and drop : starts
      // #ToDo Try to use promise in future
      setTimeout(function () {
        IDSelect2.next()
          .children()
          .children()
          .children()
          .sortable({
            containment: "parent",
            stop: function (event, ui) {
              ui.item
                .parent()
                .children("[title]")
                .each(function () {
                  var title = $(this).attr("title");
                  var original = $(
                    "option:contains(" + title + ")",
                    IDSelect2
                  ).first();
                  original.detach();
                  IDSelect2.append(original);
                });
              IDSelect2.change();
            },
          });

        $(ID).on("select2:select", function (e) {
          var element = e.params.data.element;
          var $element = $(element);

          $element.detach();
          $(this).append($element);
          $(this).trigger("change");
        });
      }, 200);
      //Manual Sorting : Select2 drag and drop : ends
    }, 100);
  });
})(jQuery);

function ea_woo_cart_column_type_title(value) {
  const labelValues = {
    remove: rea_ajax_select2_localize.remove,
    thumbnail: rea_ajax_select2_localize.thumbnail,
    name: rea_ajax_select2_localize.name,
    price: rea_ajax_select2_localize.price,
    quantity: rea_ajax_select2_localize.quantity,
    subtotal: rea_ajax_select2_localize.subtotal,
  };

  return labelValues[value] ? labelValues[value] : "";
}

function ea_conditional_logic_type_title(value) {
  const labelValues = {
    login_status: rea_ajax_select2_localize.cl_login_status,
    user_role: rea_ajax_select2_localize.cl_user_role,
    user: rea_ajax_select2_localize.cl_user,
    post_type: rea_ajax_select2_localize.cl_post_type,
    dynamic: rea_ajax_select2_localize.cl_dynamic,
    browser: rea_ajax_select2_localize.cl_browser,
    date_time: rea_ajax_select2_localize.cl_date_time,
  };

  return labelValues[value] ? labelValues[value] : "";
}
