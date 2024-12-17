$(document).ready(function () {
    window._token = $('meta[name="csrf-token"]').attr("content");

    moment.updateLocale("en", {
        week: { dow: 1 }, // Monday is the first day of the week
    });

    $(".date").datetimepicker({
        format: "YYYY-MM-DD",
        locale: "en",
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(".membership_effective_from").datetimepicker({
        format: "YYYY-MM-DD",
        locale: "en",
        minDate: new Date(),
        maxDate: getLastDayOfCurrentMonth(),
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    function getLastDayOfCurrentMonth() {
        let currentDate = new Date();
        return new Date(
            currentDate.getFullYear(),
            currentDate.getMonth() + 1,
            0
        );
    }

    $(".birth_date").datetimepicker({
        format: "YYYY-MM-DD",
        locale: "en",
        maxDate: new Date(),
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(".marriage_date").datetimepicker({
        format: "YYYY-MM-DD",
        locale: "en",
        maxDate: new Date(),
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(".from_date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });
    // .on("dp.change", function (e) {
    //     // When "from_date" changes, update the minDate for "to_date"
    //     $(".to_date").data("DateTimePicker").minDate(e.date);
    // });

    $(".to_date").datetimepicker({
        format: "DD-MM-YYYY",
        locale: "en",
        defaultDate: new Date(),
        maxDate: new Date(),
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    var defaultBirthDate = "";
    if ($("#edit_birthday").val() != "") {
        defaultBirthDate = moment($("#edit_birthday").val(), "YYYY-MM-DD");
        // console.log("insdie if", defaultBirthDate.toDate());
        // console.log("insdie if", defaultBirthDate.format("YYYY-MM-DD"));
        defaultBirthDate = defaultBirthDate.format("YYYY-MM-DD");
        // console.log("default date after format", defaultBirthDate);
    } else {
        defaultBirthDate = moment();
        // console.log("insdie else");
    }

    $(".edit_birth_date").flatpickr({
        dateFormat: "Y-m-d",
        maxDate: new Date(),
        defaultDate: defaultBirthDate,
        onChange: function (selectedDates, dateStr, instance) {
            var today_date = moment();
            today_date = today_date.format("YYYY-MM-DD");

            var from = dateStr.split("-");
            var f = new Date(from[2], from[1] - 1, from[0]);

            var years = moment().diff(f, "years") % 365;
            var months = moment().diff(f, "months") % 12;
            var days = moment().diff(f, "days") % 30;

            var totalAge =
                years + " Years " + months + " Months " + days + " Days";

            $("#member_age").val(totalAge);
        },
    });

    $(".birth_date").on("dp.change", function (event) {
        var today_date = moment();
        today_date = today_date.format("YYYY-MM-DD");

        var from = moment(event.target.value, "YYYY-MM-DD");

        // The addition of years, months and days after every statement
        // means that we actually want to add the exact number of years instead of all,months instead of all 12
        // and days instead of all 365.

        var years = moment(today_date).diff(from, "years");
        from.add(years, "years");

        var months = moment(today_date).diff(from, "months");
        from.add(months, "months");

        var days = moment(today_date).diff(from, "days");
        from.add(days, "days");

        var totalAge = years + " Years " + months + " Months " + days + " Days";

        $("#member_age").val(totalAge);
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

    $(".datetime").datetimepicker({
        format: "YYYY-MM-DD HH:mm:ss",
        locale: "en",
        sideBySide: true,
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(".timepicker").datetimepicker({
        format: "HH:mm:ss",
        icons: {
            up: "fas fa-chevron-up",
            down: "fas fa-chevron-down",
            previous: "fas fa-chevron-left",
            next: "fas fa-chevron-right",
        },
    });

    $(".select-all").click(function () {
        let $select2 = $(this).parent().siblings(".select2");
        $select2.find("option").prop("selected", "selected");
        $select2.trigger("change");
    });
    $(".deselect-all").click(function () {
        let $select2 = $(this).parent().siblings(".select2");
        $select2.find("option").prop("selected", "");
        $select2.trigger("change");
    });

    $(".select2").select2();

    $(".treeview").each(function () {
        var shouldExpand = false;
        $(this)
            .find("li")
            .each(function () {
                if ($(this).hasClass("active")) {
                    shouldExpand = true;
                }
            });
        if (shouldExpand) {
            $(this).addClass("active");
        }
    });

    $(".c-header-toggler.mfs-3.d-md-down-none").click(function (e) {
        $("#sidebar").toggleClass("c-sidebar-lg-show");

        setTimeout(function () {
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
        }, 400);
    });
});
