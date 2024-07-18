require('./bootstrap');

import 'alpinejs'

import { createFocusTrap } from 'focus-trap';
document.addEventListener('alpine:init', () => {
    console.log('msdnks');
    Alpine.data('modal', () => ({

        isModalOpen: false,
        truckId: null,
        openModal(id) {
            this.truckId = id;
            this.isModalOpen = true;
        },
        closeModal() {
            this.isModalOpen = false;
        }
    }));
})
