/**
 * Created by Wenk on 22.02.2018.
 */

var resetOrganisationIndex = 0;

$(document).ready(function () {
    $('#organisationsessionform-organisation').click(function () {
        resetOrganisationIndex = $(this).val();
    });
    $('#organisationsessionform-organisation').change(function () {
        setOrganisation($(this), resetOrganisationIndex);
    });
});

function setOrganisation(organisationDropDown, resetOrganisationIndex) {
    var index = organisationDropDown.val();
    var organisation = organisationDropDown.find("option[value=" + index + "]").val();
    var organisationTitle = organisationDropDown.find("option[value=" + index + "]").text();
    $.ajax({
        url: baseUrl + "admin/user/set-organisation",
        type: 'POST',
        data: {
            'OrganisationSessionForm[organisation]': organisation
        },
        success: function (content) {
            location.reload();
            showSuccessMessage("Organisation auf " + organisationTitle + " gesetzt");
        },
        error: function (error) {
            organisationDropDown.val(resetOrganisationIndex);
            showErrorMessage("Fehler", error.statusText);
        }
    });
}

function showSuccessMessage(title, message) {
    message = message || "";
    iziToast.show({
        title: title,
        message: message,
        color: 'green',
        timeout: 5000
    });
}

function showErrorMessage(title, message) {
    message = message || "";
    iziToast.show({
        title: title,
        message: message,
        color: 'red',
        timeout: 5000
    });
}

function showInfoMessage(title, message) {
    message = message || "";
    iziToast.show({
        title: title,
        message: message,
        color: 'yellow',
        timeout: 5000
    });
}