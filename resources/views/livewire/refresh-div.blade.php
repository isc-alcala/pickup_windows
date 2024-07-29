<div>
    <div x-data="{ interval: null }" x-init="interval = setInterval(() => { $wire.updateTime() }, 30000)">

        {{$time}}
    </div>
</div>
