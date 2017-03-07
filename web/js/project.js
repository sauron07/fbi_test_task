var addPhoneLink = jQuery('<a class="btn btn-default col-md-offset-10 add_phone_link" href="#" role="button">Add phone</a>');
var addAddressLink = jQuery('<a class="btn btn-default col-md-offset-10 add_address_link" href="#" role="button">Add address</a>');


jQuery(document).ready(function () {
    var collectionHolder = $('.collection');
    collectionHolder.find('.entry').each(function() {
        addTagFormDeleteLink($(this));
    });

    var newPhoneLink = $('<div class="new-phone-link"></div>').append(addPhoneLink);
    addNewEntry('.phones', newPhoneLink, addPhoneLink);

    var newAddressLink = $('<div class="new-address-link"></div>').append(addAddressLink);
    addNewEntry('.addresses', newAddressLink, addAddressLink);
});

function addNewEntry(selector, newLink, linkToNewEntry) {
    var collectionHolder = $(selector);
    collectionHolder.append(newLink);
    collectionHolder.data('index', collectionHolder.find(':input').length);

    linkToNewEntry.on('click', function (e) {
        e.preventDefault();
        addNewForm(collectionHolder, newLink);
    });
}

function addNewForm(collectionHolder, newLinkSelector) {
    var prototype = collectionHolder.data('prototype');
    var index = collectionHolder.data('count');
    var newForm = prototype.replace(/__name__/g, index);
    collectionHolder.data('count', index + 1);
    var newFormLi = $('<div></div>').append(newForm);

    addTagFormDeleteLink(newFormLi);

    newFormLi.append('<hr>');
    newLinkSelector.before(newFormLi);
}

function addTagFormDeleteLink(newFormLi) {
    var removeButton = jQuery('<button type="button" class="btn btn-default remove-button" style="float: right;"><span aria-hidden="true">&times;</span></button>');
    newFormLi.prepend(removeButton);

    removeButton.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the tag form
        newFormLi.remove();
    });
}