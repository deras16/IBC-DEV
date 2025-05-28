<script setup>
import { ref, watch} from "vue";
import ApexChart from "vue3-apexcharts";
import { isDark } from "@/Composables/index.js";

const props = defineProps({
    xLabel: {
        type: String,
        default: "x-axis-label"
    },
    yLabel: {
        type: String,
        default: "y-axis-label"
    },
    categories: {
        type: Array,
        required: true
    },
    series: {
        type: Array,
        required: true
    },
});

const chartKey = ref(0);

const getChartOptions = (dark) => ({
    chart: {
        type: "line",
        height: 350,
        background: dark ? "#1f2937" : "#ffffff",
        zoom: { enabled: true },
        toolbar: { show: true },
    },
    theme: {
        mode: dark ? "dark" : "light",
    },
    dataLabels: { enabled: false },
    stroke: {
        curve: "smooth",
        colors: [dark ? "#60a5fa" : "#3b82f6"],
    },
    xaxis: {
        categories: props.categories,
        labels: {
            style: {
                colors: dark ? "#d1d5db" : "#4b5563",
            },
        },
        title: {
            text: props.xLabel,
            style: {
                color: dark ? "#d1d5db" : "#4b5563",
            },
        },
    },
    yaxis: {
        labels: {
            style: {
                colors: dark ? "#d1d5db" : "#4b5563",
            },
        },
        title: {
            text: props.yLabel,
            style: {
                color: dark ? "#d1d5db" : "#4b5563",
            },
        },
    },
    grid: {
        borderColor: dark ? "#374151" : "#e5e7eb",
    },
    tooltip: {
        theme: dark ? "dark" : "light",
    },
});

const chartOptions = ref(getChartOptions(isDark.value));

watch(isDark, (newVal) => {
    chartOptions.value = getChartOptions(newVal);
    chartKey.value++;
});
</script>

<template>
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-gray-900 dark:text-gray-100 p-4 md:p-6">
        <ApexChart
            :key="chartKey"
            width="100%"
            height="450"
            type="line"
            :options="chartOptions"
            :series="series"
        />
    </div>
</template>
