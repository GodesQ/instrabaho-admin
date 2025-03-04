function showToastSuccessMessage(message) {
    Toastify({
        text: message,
        duration: 2000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #00b09b, #96c93d)",
        },
    }).showToast();
}

function showToastErrorMessage(message) {
    Toastify({
        text: message,
        duration: 2000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #fd3c3d, #e83029)",
        },
    }).showToast();
}

const handleFieldsError = (errors) => {
    // Loop through each error field
    for (const property in errors) {
        // Select the input or select element with the corresponding name
        const field = $(`[name="${property}"]`);

        // Add the 'is-invalid' class to highlight the field
        field.addClass("is-invalid");

        // Find the closest invalid-feedback div and insert the error message
        field
            .closest(".form-group")
            .find(".invalid-feedback")
            .css({ display: "block" })
            .text(errors[property][0]);

        field.closest(".form-group").find(".choices").addClass("border border-danger rounded");

        if (property == "identification_file") {
            $(`[name="identification_filename"]`)
                .closest(".filepond--root")
                .find(".filepond--drop-label")
                .addClass("border-dashed border-danger rounded border-2");
        }

        if (property == "certificate_file") {
            $(`[name="certificate_filename"]`)
                .closest(".filepond--root")
                .find(".filepond--drop-label")
                .addClass("border-dashed border-danger rounded border-2");
        }
    }
};

const handleRemoveFieldsError = () => {
    $("input").removeClass("is-invalid");
    $("textarea").removeClass("is-invalid");
    $("select").removeClass("is-invalid");
    $(".filepond--drop-label").removeClass("border-danger");
    $(".choices").removeClass("border-danger");

    $(".invalid-feedback").css({ display: "none" });
};
