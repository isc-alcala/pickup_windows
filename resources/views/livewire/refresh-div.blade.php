<div>
    <div x-data="{ interval: null }" x-init="interval = setInterval(() => { $wire.updateTime() }, 30000)">


        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800">
                    <th class="px-4 py-3"><h4></h4></th>
                    <th class="px-4 py-3"><h4> <p class="font-semibold text-2xl">PLAN</p></h4></th>
                    <th class="px-4 py-3"><h4> <p class="font-semibold text-2xl">ACTUAL</p></h4></th>
                    <th class="px-4 py-3"><h4> <p class="font-semibold text-2xl">DIFERENCIA</p></h4></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800">
                <tr class="text-gray-700 dark:text-gray-400">
                    <td  class="px-4 py-3">
                        <p class="font-semibold text-2xl">TURNO DIURNO </p>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->

                            <div>
                                <p class="font-semibold text-2xl">{{ $plandiag }}</p>

                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-2xl">
                        <p class="font-semibold text-2xl">     {{ $turnoactg }}</p>
                    </td>
                    <td class="px-4 py-3 text-2xl">
                        @if ($plandiag < $turnoactg)
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100 text-2xl">
                                {{ $totaldia }}
                            </span>
                        @else
                            <span
                                class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100 text-2xl">
                                {{ $totaldia }}
                            </span>
                        @endif
                    </td>
                </tr>
                <tr class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">
                        <p class="font-semibold text-2xl">
                            PRODUCCION ACTUAL
                       </p>
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div >
                                <p class="font-semibold text-2xl">      {{ $canpart }}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-2xl">
                        <p class="font-semibold text-2xl">   {{ $produc }}</p>
                    </td>
                    <td class="px-4 py-3 text-2xl">
                        @if ($produc > $canpart)
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100  text-2xl">
                            {{$produc- $canpart}}
                        </span>
                    @else
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-red-700 bg-red-100 rounded-full dark:bg-red-700 dark:text-red-100 text-2xl">
                            {{$produc- $canpart}}
                        </span>
                    @endif

                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
