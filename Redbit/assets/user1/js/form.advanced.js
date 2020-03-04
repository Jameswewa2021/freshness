$(function() {
    /*
    -------------------------------------------------
        Select2
    -------------------------------------------------
    */
    $(".select2-multiple").select2();

    /*
    -------------------------------------------------
        Bootstrap datepicker
    -------------------------------------------------
    */
    $(".bs-datepicker").datepicker({
        format: "dd/mm/yyyy",
        orientation: "bottom auto"
    });

    // datapicker inline
    $(".bs-datepicker-inline").datepicker({
        format: "dd/mm/yyyy",
    });

    /*
    -------------------------------------------------
        Editable
    -------------------------------------------------
    */
    $('#editable-text').editable({
        type: 'text',
        tpl: '<input type="" class="form-control xeditable-control" />'
    });

    $('#editable-select').editable({
        source: [{
            value: 1,
            text: 'Male'
        }, {
            value: 2,
            text: 'Female'
        }]
    });

    $('#editable-textarea').editable({
        type: 'textarea',
        tpl: '<textarea class="form-control h-70"></textarea>'
    });

    /*
    -------------------------------------------------
        Dropzone
    -------------------------------------------------
    */
    $(".form-dropzone").dropzone({
        url: "/"
    });

    /*
    -------------------------------------------------
        Dropify
    -------------------------------------------------
    */
    $('.dropify').dropify();

    /*
    -------------------------------------------------
        Multi Select
    -------------------------------------------------
    */
    $('#multi-select').multiSelect();

    /*
    -------------------------------------------------
        Range Slider
    -------------------------------------------------
    */
    $(".range-slider1").ionRangeSlider();

    $(".range-slider2").ionRangeSlider({
        type: "double",
        grid: true,
        min: 0,
        max: 1000,
        from: 200,
        to: 800,
        prefix: "$"
    });

    /*
    -------------------------------------------------
        Summer Note
    -------------------------------------------------
    */
    $('.summernote').summernote({
        height: 400
    });
});