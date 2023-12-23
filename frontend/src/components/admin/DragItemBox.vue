<template>
	<ItemBox
		class="flex flex-col items-stretch px-0 pb-1 pt-1 space-y-2"
		:draggable="allowDrag"
		:title="boxTitle"
		@dragstart="dragStart"
		@dragend="dragEnd">
		<div
			id="dragbutton"
			class="w-full flex justify-center text-gray-400"
			@mouseover="allowDrag = true"
			@mouseleave="allowDrag = false">
			<font-awesome-icon :icon="icons.faGripHorizontal" />
		</div>
		<div class="w-full rounded-l-lg px-3">
			<slot></slot>
		</div>
		<hr />
		<div class="w-full px-3 flex justify-end">
			<div class="">
				<button @click="$emit('delete', `${item.id}${item.type}`)">
					<font-awesome-icon
						:icon="icons.faTrash"
						class="h-4 w-4 hover:text-gray-400 text-gray-500" />
				</button>
			</div>
		</div>
	</ItemBox>
</template>
<script>
import ItemBox from "./ItemBox.vue";
import { faTrash, faGripHorizontal } from "@fortawesome/free-solid-svg-icons";

export default {
	components: { ItemBox },
	props: ["item", "boxTitle"],
	emits: ["delete", "startedDragging", "endedDragging"],
	data() {
		return {
			allowDrag: false,
			icons: {
				faGripHorizontal,
				faTrash,
			},
		};
	},
	methods: {
		dragStart(e) {
			if (!this.allowDrag) {
				return;
			}
			e.dataTransfer.setData("text/plain", JSON.stringify(this.item));
			this.$emit("startedDragging", true);
		},
		dragEnd() {
			this.allowDrag = false;
			this.$emit("endedDragging", true);
			//this.$store.commit("drag/stopDragging")
		},
	},
};
</script>
