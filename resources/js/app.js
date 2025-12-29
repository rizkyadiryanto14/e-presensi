import './bootstrap';

import Alpine from 'alpinejs';
import 'flowbite';

import { DataTable } from 'simple-datatables';
import 'simple-datatables/dist/style.css';

window.Alpine = Alpine;
window.simpleDatatables = { DataTable };

Alpine.start();
