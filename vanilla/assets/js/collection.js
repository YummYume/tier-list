document.body.addEventListener('click', (e) => {
    const clickedNode = e.target;

    if (clickedNode.dataset.typeButton === 'add') {
        const prototype = clickedNode.closest('[data-prototype]');

        if (prototype) {
            const template = prototype.dataset.prototype;
            const collection = prototype.querySelector('[data-collection]');
            const templateName = new RegExp(prototype.dataset.prototypeName ?? '__name__', 'g');
            const newEntry = template.replace(templateName, collection ? collection.childElementCount : prototype.childElementCount);

            if (collection) {
                collection.insertAdjacentHTML('beforeend', newEntry);
            } else {
                prototype.insertAdjacentHTML('beforeend', newEntry);
            }
        }
    } else if (clickedNode.dataset.typeButton === 'remove') {
        const entry = clickedNode.closest('[data-entry]');

        if (entry) {
            entry.remove();
        }
    }
});
