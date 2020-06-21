var rules = {
    work_name: "required",
    start_date: "required",
    end_date: "required",
    status: "required",
}

var messages = {
    work_name: "Please enter work name",
    start_date: "Please choose start date",
    end_date: "Please choose end date",
    status: "Please select status",
}

var validate = {
    rules: rules,
    messages: messages,
    errorElement: "em",
    errorPlacement: function(error, element) {
        // Add the `text-danger` class to the error element
        error.addClass("text-danger");

        if (element.prop("type") === "checkbox") {
            error.insertAfter(element.parent("label"));
        } else {
            error.insertAfter(element);
        }
    },
    highlight: function(element, errorClass, validClass) {
        $(element).parents(".col-sm-5").addClass("has-error").removeClass("has-success");
    },
    unhighlight: function(element, errorClass, validClass) {
        $(element).parents(".col-sm-5").addClass("has-success").removeClass("has-error");
    }
}

$('.datetime').datetimepicker({
    format: 'YYYY-MM-DD HH:mm',
    defaultDate: new Date(),
});

$("#create-form").validate(validate);

$("#update-form").validate(validate);

$('.remove-work').click(function(event) {
    var checkConfirmDelete = confirm('Are you sure you want to delete this work?');
    var el = $(this)
    var id = el.data('id')
    if (checkConfirmDelete) {
        $.ajax({
            url: 'work/delete',
            type: 'POST',
            dataType: 'json',
            data: {id: id},
        })
        .done(function() {
            console.log("success");
            el.closest('tr').remove()
        })
        .fail(function() {
            console.log("error");
        })
        .always(function() {
            console.log("complete");
        });
        
    }
});
