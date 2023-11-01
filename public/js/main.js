$(document).ready(function () {
  window._token = $('meta[name="csrf-token"]').attr('content')

  moment.updateLocale('en', {
    week: { dow: 1 } // Monday is the first day of the week
  })

  $('.date').datetimepicker({
    format: 'YYYY-MM-DD',
    locale: 'en',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  });



  $('.birth_date').datetimepicker({
    format: 'DD-MM-YYYY',
    locale: 'en',
    maxDate: new Date(),
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    },
  });

  var defaultBirthDate = '';
  if ($("#edit_birthday").val() != '') {
    defaultBirthDate = moment($("#edit_birthday").val(), 'DD-MM-YYYY');
    console.log("insdie if", defaultBirthDate.toDate());
    console.log("insdie if", defaultBirthDate.format("DD-MM-YYYY"));
    defaultBirthDate = defaultBirthDate.format("DD-MM-YYYY");
    console.log("default date after format", defaultBirthDate);
  }
  else {
    defaultBirthDate = moment();
    console.log("insdie else");
  }

  $(".edit_birth_date").flatpickr({
    dateFormat: "d-m-Y",
    maxDate: new Date(),
    defaultDate: defaultBirthDate,
    onChange: function (selectedDates, dateStr, instance) {

      var today_date = moment();
      today_date = today_date.format("DD-MM-YYYY");


      var from = dateStr.split("-");
      var f = new Date(from[2], from[1] - 1, from[0]);

      var years = moment().diff(f, 'years') % 365;
      var months = moment().diff(f, 'months') % 12;
      var days = moment().diff(f, 'days') % 30;

      var totalAge = years + " Years " + months + " Months " + days + " Days";

      $('#member_age').val(totalAge);

    }
  });

  $(".birth_date").on("dp.change", function (event) {

    var today_date = moment();
    today_date = today_date.format("DD-MM-YYYY");


    var from = event.target.value.split("-");
    var f = new Date(from[2], from[1] - 1, from[0]);

    var years = moment().diff(f, 'years') % 365;
    var months = moment().diff(f, 'months') % 12;
    var days = moment().diff(f, 'days') % 30;

    var totalAge = years + " Years " + months + " Months " + days + " Days";

    $('#member_age').val(totalAge);


  });

  $(".edit_birth_date").on("dp.change", function (event) {

    // var today_date = moment();
    // today_date = today_date.format("DD-MM-YYYY");


    // var from = event.target.value.split("-");
    // var f = new Date(from[2], from[1] - 1, from[0]);

    // var years = moment().diff(f, 'years') % 365;
    // var months = moment().diff(f, 'months') % 12;
    // var days = moment().diff(f, 'days') % 30;

    // var totalAge = years+ " Years "+ months+ " Months "+ days+ " Days";

    // $('#member_age').val(totalAge);


  });



  $('.datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm:ss',
    locale: 'en',
    sideBySide: true,
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.timepicker').datetimepicker({
    format: 'HH:mm:ss',
    icons: {
      up: 'fas fa-chevron-up',
      down: 'fas fa-chevron-down',
      previous: 'fas fa-chevron-left',
      next: 'fas fa-chevron-right'
    }
  })

  $('.select-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', 'selected')
    $select2.trigger('change')
  })
  $('.deselect-all').click(function () {
    let $select2 = $(this).parent().siblings('.select2')
    $select2.find('option').prop('selected', '')
    $select2.trigger('change')
  })

  $('.select2').select2()

  $('.treeview').each(function () {
    var shouldExpand = false
    $(this).find('li').each(function () {
      if ($(this).hasClass('active')) {
        shouldExpand = true
      }
    })
    if (shouldExpand) {
      $(this).addClass('active')
    }
  })

  $('.c-header-toggler.mfs-3.d-md-down-none').click(function (e) {
    $('#sidebar').toggleClass('c-sidebar-lg-show');

    setTimeout(function () {
      $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    }, 400);
  });

})
