function showToastSuccessMessage(message) {
    Toastify({
        text: message,
        duration: 3000,
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
        duration: 3000,
        close: true,
        gravity: "top", // `top` or `bottom`
        position: "center", // `left`, `center` or `right`
        stopOnFocus: true, // Prevents dismissing of toast on hover
        style: {
            background: "linear-gradient(to right, #7d0e19, #7d0e19)",
            boxShadow: "0 3px 6px -1px #7d0e19, 0 6px 0px -4px #7d0e19",
        },
    }).showToast();
}

function showDeleteMessage(options) {
    Swal.fire({
        html:
            '<div class="mt-3">' +
            '<lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#41528a,secondary:#f06548" style="width:100px;height:100px"></lord-icon>' +
            '<div class="mt-4 pt-2 fs-15 mx-5">' +
            "<h4>Are you Sure ?</h4>" +
            '<p class="text-muted mx-4 mb-0">' +
            options.message +
            "</p>" +
            "</div>" +
            "</div>",
        showCancelButton: true,
        customClass: {
            confirmButton: "btn btn-success w-xs me-2 mb-1 confirm-delete",
            cancelButton: "btn btn-dark w-xs mb-1",
        },
        confirmButtonText: "Yes, Remove It!",
        buttonsStyling: false,
        showCloseButton: false,
    }).then((result) => {
        if (result.isConfirmed) {
            if (typeof options.deleteFunction === "function") {
                options.deleteFunction();
            }
        }
    });
}

function showSuccessMessage(message) {
    return Swal.fire({
        html:
            '<div class="mt-3">' +
            '<lord-icon src="https://cdn.lordicon.com/lupuorrc.json" trigger="loop" colors="primary:#0ab39c,secondary:#405189" style="width:120px;height:120px"></lord-icon>' +
            '<div class="mt-4 pt-2 fs-15">' +
            "<h4>Well done !</h4>" +
            '<p class="text-muted mx-4 mb-0">' +
            message +
            ".</p>" +
            "</div>" +
            "</div>",
        showCancelButton: true,
        showConfirmButton: false,
        customClass: {
            cancelButton: "btn btn-primary w-xs mb-1",
        },
        cancelButtonText: "Okay",
        buttonsStyling: false,
        showCloseButton: true,
    });
}

function showErrorMessage(message) {
    return Swal.fire({
        html:
            '<div class="mt-3">' +
            '<lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f06548,secondary:#f7b84b" style="width:120px;height:120px"></lord-icon>' +
            '<div class="mt-4 pt-2 fs-15">' +
            "<h4>Oops...! Something went Wrong !</h4>" +
            '<p class="text-muted mx-4 mb-0">' +
            message +
            "</p>" +
            "</div>" +
            "</div>",
        showCancelButton: true,
        showConfirmButton: false,
        customClass: {
            cancelButton: "btn btn-primary w-xs mb-1",
        },
        cancelButtonText: "Dismiss",
        buttonsStyling: false,
        showCloseButton: true,
    });
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
