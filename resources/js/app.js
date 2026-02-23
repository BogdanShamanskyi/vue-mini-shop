import './bootstrap';

import Alpine from 'alpinejs';

import { createPinia } from 'pinia'
import { mountWidgets } from './bootstrap/mount'
import { widgets } from './widgets'

const pinia = createPinia()
mountWidgets({ pinia, widgets })

window.Alpine = Alpine;
Alpine.start();
