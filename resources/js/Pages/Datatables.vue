<script setup>
import { Head, Link } from "@inertiajs/vue3";

import DataTable from 'datatables.net-vue3'
import DataTablesCore from 'datatables.net-dt';
// import DataTablesCore from 'datatables.net-bs5';
import 'datatables.net-autofill-dt';
import 'datatables.net-buttons-dt';
import 'datatables.net-buttons/js/buttons.colVis.mjs';
import 'datatables.net-buttons/js/buttons.html5.mjs';
import 'datatables.net-colreorder-dt';
import 'datatables.net-columncontrol-dt';
import DateTime from 'datatables.net-datetime';
import 'datatables.net-fixedcolumns-dt';
import 'datatables.net-searchpanes-dt';
import 'datatables.net-select-dt';

DataTable.use(DataTablesCore);

const data = [
  [1, 2],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
  [3, 4],
];
</script>

<template>
    <Head title="Welcome" />
    <div class="flex justify-center items-center mt-3 bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <DataTable :data="data" class="display w-lg" :options="{select: true, sort: true}">
            <thead class="bg-green-400/50">
                <tr>
                    <th class="border border-gray-300 p-2">First</th>
                    <th class="border border-gray-300 p-2">Second</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
        </DataTable>
    </div>
</template>
