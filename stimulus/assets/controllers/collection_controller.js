import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['entries', 'entry'];
    static values = {
        prototype: String,
        prototypeName: '__name__',
        itemCount: Number,
    };

    connect() {
        this.itemCountValue = this.entriesTarget.childElementCount;
    }

    add() {
        const newEntry = this.prototypeValue.replace(new RegExp(this.prototypeNameValue, 'g'), this.itemCountValue);

        this.entriesTarget.insertAdjacentHTML('beforeend', newEntry);
        this.itemCountValue++;
    }

    remove(event) {
        const element = event.target;
        const entry = this.entryTargets.find(e => e.contains(element));

        if (entry) {
            entry.remove();
            this.itemCountValue--;
        }
    }
}
