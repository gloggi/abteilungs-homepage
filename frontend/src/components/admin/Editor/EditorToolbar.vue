<template>
  <div
    v-if="editor"
    class="flex flex-wrap items-center gap-1 border-b border-gray-200 bg-gray-50/50 p-1"
  >
    <EditorButton
      @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
      :active="editor.isActive('heading', { level: 2 })"
    >
      <font-awesome-icon class="size-4" :icon="icons.faHeading" />
      <span class="text-xs font-bold ml-0.5">2</span>
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
      :active="editor.isActive('heading', { level: 3 })"
    >
      <font-awesome-icon class="size-4" :icon="icons.faHeading" />
      <span class="text-xs font-bold ml-0.5">3</span>
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton
      @click="editor.chain().focus().toggleBold().run()"
      :active="editor.isActive('bold')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faBold" />
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleItalic().run()"
      :active="editor.isActive('italic')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faItalic" />
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleUnderline().run()"
      :active="editor.isActive('underline')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faUnderline" />
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleStrike().run()"
      :active="editor.isActive('strike')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faStrikethrough" />
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton @click.self.prevent>
      <EditorColorPicker v-model="computedTextColor" />
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton
      @click="editor.chain().focus().toggleBulletList().run()"
      :active="editor.isActive('bulletList')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faList" />
    </EditorButton>
    <EditorButton
      @click="editor.chain().focus().toggleOrderedList().run()"
      :active="editor.isActive('orderedList')"
    >
      <font-awesome-icon class="size-4" :icon="icons.faListOl" />
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton @click="$emit('add-image')">
      <font-awesome-icon class="size-4" :icon="icons.faImage" />
    </EditorButton>
    <EditorButton v-if="!editor.isActive('link')" @click="$emit('ask-for-link')">
      <font-awesome-icon class="size-4" :icon="icons.faLink" />
    </EditorButton>
    <EditorButton
      v-else
      @click="editor.chain().focus().unsetLink().run()"
      :active="true"
    >
      <font-awesome-icon class="size-4" :icon="icons.faLinkSlash" />
    </EditorButton>

    <div class="h-4 w-px bg-gray-200 mx-1"></div>

    <EditorButton
      @click="handleAlign('left', 'float-left')"
      :active="
        editor.isActive({ textAlign: 'left' }) ||
        (editor.isActive('image') &&
          editor.getAttributes('image').class === 'float-left')
      "
    >
      <font-awesome-icon class="size-4" :icon="icons.faAlignLeft" />
    </EditorButton>
    <EditorButton
      @click="handleAlign('center', 'block mx-auto')"
      :active="
        editor.isActive({ textAlign: 'center' }) ||
        (editor.isActive('image') &&
          editor.getAttributes('image').class === 'block mx-auto')
      "
    >
      <font-awesome-icon class="size-4" :icon="icons.faAlignCenter" />
    </EditorButton>
    <EditorButton
      @click="handleAlign('right', 'float-right')"
      :active="
        editor.isActive({ textAlign: 'right' }) ||
        (editor.isActive('image') &&
          editor.getAttributes('image').class === 'float-right')
      "
    >
      <font-awesome-icon class="size-4" :icon="icons.faAlignRight" />
    </EditorButton>

    <div class="ml-auto flex items-center gap-1">
      <EditorButton @click="editor.chain().focus().undo().run()">
        <font-awesome-icon class="size-4" :icon="icons.faArrowRotateLeft" />
      </EditorButton>
      <EditorButton @click="editor.chain().focus().redo().run()">
        <font-awesome-icon class="size-4" :icon="icons.faArrowRotateRight" />
      </EditorButton>
      <div class="h-4 w-px bg-gray-200 mx-1"></div>
      <EditorButton @click="$emit('swap-editor-content')" :active="showHTML">
        <font-awesome-icon class="size-4" :icon="icons.faCode" />
      </EditorButton>
    </div>
  </div>
</template>

<script>
import EditorButton from "./EditorButton.vue";
import EditorColorPicker from "./EditorColorPicker.vue";
import {
  faArrowRotateLeft,
  faArrowRotateRight,
  faList,
  faListOl,
  faCode,
  faLink,
  faLinkSlash,
  faImage,
  faHeading,
  faAlignRight,
  faAlignLeft,
  faAlignCenter,
  faBold,
  faItalic,
  faStrikethrough,
  faUnderline,
} from "@fortawesome/free-solid-svg-icons";

export default {
  props: {
    editor: {
      type: Object,
      required: true,
    },
    showHTML: {
      type: Boolean,
      default: false,
    },
  },
  components: {
    EditorButton,
    EditorColorPicker,
  },
  emits: ["add-image", "ask-for-link", "swap-editor-content"],
  data() {
    return {
      icons: {
        faArrowRotateLeft,
        faArrowRotateRight,
        faList,
        faListOl,
        faCode,
        faLink,
        faLinkSlash,
        faImage,
        faHeading,
        faAlignRight,
        faAlignLeft,
        faAlignCenter,
        faBold,
        faItalic,
        faStrikethrough,
        faUnderline,
      },
    };
  },
  computed: {
    computedTextColor: {
      get() {
        return this.editor.getAttributes("textStyle").color
          ? this.editor.getAttributes("textStyle").color
          : "#333333";
      },
      set(value) {
        this.editor.chain().focus().setColor(value).run();
      },
    },
  },
  methods: {
    handleAlign(text, imageClass) {
      this.editor.chain().focus();
      if (this.editor.isActive("image")) {
        console.log("image");
        this.editor
          .chain()
          .updateAttributes("image", { class: imageClass })
          .run();
      } else {
        console.log("text");
        this.editor.chain().setTextAlign(text).run();
      }
    },
  },
};
</script>
