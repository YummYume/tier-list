document.body.addEventListener('click', (e) => {
    const clickedNode = e.target;

    if (clickedNode.dataset.typeButton === 'add') {
        const prototype = clickedNode.closest('[data-prototype]');

        if (prototype) {
            const template = prototype.dataset.prototype;
            const collection = prototype.querySelector('[data-collection]');
            const newEntry = document.createElement('div');
            newEntry.innerHTML = template.replace(/__name__/g, collection ? collection.childElementCount : prototype.childElementCount);

            if (collection) {
                collection.appendChild(newEntry);
            } else {
                prototype.appendChild(newEntry);
            }
        }
    } else if (clickedNode.dataset.typeButton === 'remove') {
        const entry = clickedNode.closest('[data-entry]');

        if (entry) {
            entry.remove();
        }
    }
});
