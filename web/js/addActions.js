// Adapted from https://symfony.com/doc/3.4/form/form_collections.html


var $collectionHolder;

// setup an "add an action" link
var $addActLink = $('<p><a class="btn btn-success btn-block" href="#" class="add_act_link">Add an action</a></p>');
var $newLinkLi = $('<li></li>').append($addActLink);

jQuery(document).ready(function() {
    // Get the ul that holds the collection of actions
    $collectionHolder = $('ul.acts');

    // add a delete link to all of the existing action form li elements
    $collectionHolder.find('li').each(function() {
        addActFormDeleteLink($(this));
    })

    // add the "add an action" anchor and li to the actions ul
    $collectionHolder.append($newLinkLi);

    // count the current form inputs we have (e.g. 2), use that as the new
    // index when inserting a new item (e.g. 2)
    $collectionHolder.data('index', $collectionHolder.find(':input').length);

    $addActLink.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // add a new action form (see next code block)
        addActForm($collectionHolder, $newLinkLi);
    });
});

function addActForm($collectionHolder, $newLinkLi) {
    // Get the data-prototype explained earlier
    var prototype = $collectionHolder.data('prototype');

    // get the new index
    var index = $collectionHolder.data('index');

    var newForm = prototype;
    // You need this only if you didn't set 'label' => false in your tags field in TaskType
    // Replace '__name__label__' in the prototype's HTML to
    // instead be a number based on how many items we have
    // newForm = newForm.replace(/__name__label__/g, index);

    // Replace '__name__' in the prototype's HTML to
    // instead be a number based on how many items we have
    newForm = newForm.replace(/__name__/g, index);

    // increase the index with one for the next item
    $collectionHolder.data('index', index + 1);

    // Display the form in the page in an li, before the "Add a tag" link li
    var $newFormLi = $('<li></li>').append(newForm);
    addActFormDeleteLink($newFormLi);
    $newLinkLi.before($newFormLi);

}

function addActFormDeleteLink($actFormLi) {
    var $removeFormA = $('<p><a class="btn btn-warning btn-block"  href="#">delete this action</a></p>');
    $actFormLi.append($removeFormA);

    $removeFormA.on('click', function(e) {
        // prevent the link from creating a "#" on the URL
        e.preventDefault();

        // remove the li for the act form
        $actFormLi.remove();
    });
}