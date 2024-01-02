<template>
	<div>
		<div class="w-full px-24">
			<div class="border border-primary mb-2">
				<button
					@click="show = !show"
					class="text-left w-full bg-primary p-5 flex flex-col text-white">
					<HeadingOne>{{ event.title }}</HeadingOne>
					<div class="grid grid-cols-2 w-full">
						<p class="main-text text-white text-xl">
							<span class="font-semibold">Datum:</span>
							{{ getDate(event) }}
						</p>
						<p class="main-text text-white text-xl">
							<span class="font-semibold">Zeit:</span>
							{{ formatTime(event.startTime) }} -
							{{ formatTime(event.endTime) }}
						</p>
						<p class="main-text text-white text-xl">
							<span class="font-semibold">Ort:</span>
							{{ event.startLocation.name }}
						</p>
						<p
							v-if="event.groups.length > 1"
							class="main-text text-white text-xl">
							<span class="font-semibold">Gruppen:</span>
							{{ event.groups.map((g) => g.name).join(", ") }}
						</p>
					</div>
				</button>
				<Transition @beforeEnter="beforeEnter" @enter="enter" @leave="leave">
					<div v-if="show" class="h-full">
						<Map
							class="w-full h-96"
							:markers="[event.startLocation, event.endLocation]" />
						<div class="p-3">
							<div v-html="event.description" v-router-link></div>

							<h4
								v-if="event.takeWithYou"
								class="font-bold text-3xl text-primary pt-2">
								Mitnehmen
							</h4>
							<div
								v-if="event.takeWithYou"
								v-html="event.takeWithYou"
								v-router-link></div>
						</div>
					</div>
				</Transition>
			</div>
		</div>
	</div>
</template>
<script>
import HeadingOne from "./HeadingOne.vue";
import Map from "./Map.vue";
import { format } from "date-fns";
import { de } from "date-fns/locale";
import { gsap } from "gsap";

export default {
	props: ["event"],
	components: { HeadingOne, Map },
	props: {
		open: {
			type: Boolean,
			default: false,
		},
		event: {
			type: Object,
			required: true,
		},
	},
	data() {
		return {
			show: false,
		};
	},
	methods: {
		formatDate(date) {
			return format(new Date(date), "dd. MMMM yyyy", { locale: de });
		},
		formatTime(date) {
			return format(new Date(date), "HH:mm");
		},
		isSameDay(date1, date2) {
			return (
				format(new Date(date1), "dd.MM.yyyy") ===
				format(new Date(date2), "dd.MM.yyyy")
			);
		},
		getDate(event) {
			if (this.isSameDay(event.startTime, event.endTime)) {
				return this.formatDate(event.startTime);
			}
			if (
				format(new Date(event.startTime), "yyyy") ===
				format(new Date(event.endTime), "yyyy")
			) {
				return `${format(new Date(event.startTime), "dd.MM.")} - ${format(
					new Date(event.endTime),
					"dd.MM.yyyy",
				)}`;
			}
			return `${format(new Date(event.startTime), "dd. MM yyyy")} - ${format(
				new Date(event.endTime),
				"dd. MM yyyy",
			)}`;
		},
		beforeEnter(el) {
			el.style.height = "0";
			el.style.overflow = "hidden";
		},
		enter(el, done) {
			gsap.to(el, { height: "auto", duration: 0.3, onComplete: done });
		},
		leave(el, done) {
			gsap.to(el, { height: "0", duration: 0.3, onComplete: done });
		},
	},
	created() {
		this.show = this.open;
	},
};
</script>
