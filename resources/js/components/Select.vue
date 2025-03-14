<template>
    <div class="select-wrapper relative">
        <button 
            class="select h-full px-3 py-1 rounded border flex justify-between items-center font-semibold shadow w-full cursor-pointer focus:ring focus-ring-sky-500" 
            @click="showOptions = !showOptions"
            type="button"
        >
            <p>{{  options.find(option => option.value == model)?.label || props.placeholder }}</p>
            <ChevronDown class="size-5 stroke-2"></ChevronDown>
        </button>
        
        <transition
            enter-active-class="transition duration-300 ease-out"
            enter-from-class="opacity-0 -translate-y-1"
            leave-active-class="transition duration-300 ease-in"
            leave-to-class="opacity-0 -translate-y-1"
        >
            <ul class="options mt-2 rounded border divide-y absolute bg-white w-full shadow z-50" v-show="showOptions">
                <li class="option px-3 py-1 hover:bg-slate-50 cursor-pointer" 
                :class="{ 'bg-slate-100': option.value == model }"
                v-for="option in options" @click="chooseOption(option)">{{ option.label }} <span v-if="option.value == model"><Check class="size-6 float-right"></Check></span></li>
            </ul>
        </transition>
    </div>
</template>

<script setup>
import { ChevronDown } from 'lucide-vue-next';
import { Check } from 'lucide-vue-next';
import { ref } from 'vue';

const props = defineProps({
    options: {
        type: Array,
        default: () => []
    },
    placeholder: {
        type: String,
        default: 'Please select an item'
    }
})
const model = defineModel()

const showOptions = ref(false)

const chooseOption = (option) => {
    showOptions.value = false
    model.value = option.value
}


</script>