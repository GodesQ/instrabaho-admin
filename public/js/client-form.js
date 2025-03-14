const navigateToInvalidFieldTab = (errors) => {
    const tabMappings = [
        {
            fields: ["first_name", "last_name", "username", "email"],
            selector: "#v-pills-account-info-tab",
        },
        {
            fields: ["contact_number", "gender", "birthdate", "address", "latitude", "longitude"],
            selector: "#v-pills-profile-info-tab",
        },
        {
            fields: ["tagline", "hourly_rate", "personal_description", "identification_file"],
            selector: "#v-pills-worker-info-tab",
        },
        {
            fields: ["certificate_title", "certificate_issue_date", "certificate_file"],
            selector: "#v-pills-worker-certificates-tab",
        },
    ];

    for (const { fields, selector } of tabMappings) {
        if (fields.some((field) => errors.hasOwnProperty(field))) {
            const tabElement = document.querySelector(selector);
            if (tabElement) {
                // Ensure the element exists
                tabElement.click();
                return; // Exit after clicking the first matching tab
            }
        }
    }
};

const setupFilePond = () => {
    const identificationFileInput = document.querySelector("#identification-file-field");

    const certificateFileInput = document.querySelector("#certificate-file-field");

    FilePond.registerPlugin(
        // encodes the file as base64 data
        FilePondPluginFileEncode,
        // validates the size of the file
        FilePondPluginFileValidateSize,
        // corrects mobile image orientation
        FilePondPluginImageExifOrientation,
        // previews dropped images
        FilePondPluginImagePreview
    );

    identificationPond = FilePond.create(identificationFileInput, {
        name: "identification_filename",
        labelIdle: 'Drag & Drop your image or <span class="filepond--label-action">Browse</span>',
        acceptedFileTypes: ["image/*"],
        required: true,
        allowMultiple: false,
    });

    certificatePond = FilePond.create(certificateFileInput, {
        name: "certificate_filename",
        labelIdle: 'Drag & Drop your image or <span class="filepond--label-action">Browse</span>',
        acceptedFileTypes: ["image/*"],
        required: true,
        allowMultiple: false,
    });
};
