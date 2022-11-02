$(document.body).on('click', '[data-type-button="add"]', (e) => {
    const clickedNode = e.target;
    const prototype = $(clickedNode).closest('[data-prototype]');

    if (prototype.length > 0) {
        const template = $(prototype).data('prototype');
        const collection = $(prototype).find('div[data-collection]');
        const templateName = new RegExp(prototype.data('prototypeName') ?? '__name__', 'g');
        const newEntry = template.replace(templateName, collection.length > 0 ? collection.children().length : prototype.children().length);

        if (collection.length > 0) {
            collection.first().append(newEntry);
        } else {
            $(prototype).append(newEntry);
        }
    }
});

$(document.body).on('click', '[data-type-button="remove"]', (e) => {
    const clickedNode = e.target;
    const entry = $(clickedNode).closest('[data-entry]');

    if (entry.length > 0) {
        $(entry).remove();
    }
});
