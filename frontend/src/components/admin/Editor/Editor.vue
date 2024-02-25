<template>
  <div class="rounded-lg bg-gray-100 p-2">
    <div v-if="editor" class="flex justify-between">
      <div class="flex flex-col">
        <div class="flex">
          <EditorButton
            @click="editor.chain().focus().toggleHeading({ level: 1 }).run()"
            :active="editor.isActive('heading', { level: 1 })"
          >
            <font-awesome-icon class="h-4 w-4" :icon="icons.faHeading" /><sub
              class="font-bold"
              >1</sub
            >
          </EditorButton>
          <EditorButton
            @click="editor.chain().focus().toggleHeading({ level: 2 }).run()"
            :active="editor.isActive('heading', { level: 2 })"
          >
            <font-awesome-icon class="h-4 w-4" :icon="icons.faHeading" /><sub
              class="font-bold"
              >2</sub
            >
          </EditorButton>
          <EditorButton
            @click="editor.chain().focus().toggleHeading({ level: 3 }).run()"
            :active="editor.isActive('heading', { level: 3 })"
          >
            <font-awesome-icon class="h-4 w-4" :icon="icons.faHeading" /><sub
              class="font-bold"
              >3</sub
            >
          </EditorButton>
          <EditorButton @click.self.prevent>
            <input
              type="color"
              @input="
                editor.chain().focus().setColor($event.target.value).run()
              "
              :value="
                () =>
                  editor.getAttributes('textStyle').color == ''
                    ? '#000000'
                    : editor.getAttributes('textStyle')
              "
            />
          </EditorButton>
        </div>
        <div class="flex flex-col md:flex-row">
          <div>
            <EditorButton
              class="font-bold"
              @click="editor.chain().focus().toggleBold().run()"
              :active="editor.isActive('bold')"
            >
              Bold
            </EditorButton>
            <EditorButton
              class="italic"
              @click="editor.chain().focus().toggleItalic().run()"
              :active="editor.isActive('italic')"
            >
              Italic
            </EditorButton>
            <EditorButton
              class="line-through"
              @click="editor.chain().focus().toggleStrike().run()"
              :active="editor.isActive('strike')"
            >
              strike
            </EditorButton>
            <EditorButton
              @click="editor.chain().focus().toggleBulletList().run()"
              :active="editor.isActive('bulletList')"
            >
              <font-awesome-icon class="h-5 w-5" :icon="icons.faList" />
            </EditorButton>
          </div>
          <div>
            <EditorButton @click="addImage">
              <font-awesome-icon class="h-5 w-5" :icon="icons.faImage" />
            </EditorButton>
            <EditorButton v-if="!editor.isActive('link')" @click="setLink">
              <font-awesome-icon class="h-5 w-5" :icon="icons.faLink" />
            </EditorButton>
            <EditorButton
              v-if="editor.isActive('link')"
              @click="editor.chain().focus().unsetLink().run()"
            >
              <font-awesome-icon class="h-5 w-5" :icon="icons.faLinkSlash" />
            </EditorButton>
            <EditorButton @click="swapEditorContent" :active="showHTML">
              <font-awesome-icon class="h-5 w-5" :icon="icons.faCode" />
            </EditorButton>
            <EditorButton
              @click="editor.chain().focus().setTextAlign('right').run()"
              :active="editor.isActive({ textAlign: 'right' })"
            >
              <font-awesome-icon class="h-5 w-5" :icon="icons.faAlignRight" />
            </EditorButton>
          </div>
        </div>
      </div>
      <div class="flex items-start">
        <EditorButton @click="editor.chain().focus().undo().run()">
          <font-awesome-icon class="h-6 w-6" :icon="icons.faArrowRotateLeft" />
        </EditorButton>
        <EditorButton @click="editor.chain().focus().redo().run()">
          <font-awesome-icon class="h-6 w-6" :icon="icons.faArrowRotateRight" />
        </EditorButton>
      </div>
    </div>
    <div v-if="editor && false" class="grid grid-cols-10 gap-1">
      <EditorButton
        @click="editor.chain().focus().toggleCode().run()"
        :active="editor.isActive('code')"
      >
        code
      </EditorButton>
      <EditorButton @click="editor.chain().focus().unsetAllMarks().run()">
        clear marks
      </EditorButton>
      <EditorButton @click="editor.chain().focus().clearNodes().run()">
        clear nodes
      </EditorButton>
      <EditorButton
        @click="editor.chain().focus().setParagraph().run()"
        :active="editor.isActive('paragraph')"
      >
        paragraph
      </EditorButton>

      <EditorButton
        @click="editor.chain().focus().toggleBulletList().run()"
        :active="editor.isActive('bulletList')"
      >
        bullet list
      </EditorButton>
      <EditorButton
        @click="editor.chain().focus().toggleOrderedList().run()"
        :active="editor.isActive('orderedList')"
      >
        ordered list
      </EditorButton>
      <EditorButton
        @click="editor.chain().focus().toggleCodeBlock().run()"
        :active="editor.isActive('codeBlock')"
      >
        code block
      </EditorButton>
      <EditorButton
        @click="editor.chain().focus().toggleBlockquote().run()"
        :active="editor.isActive('blockquote')"
      >
        blockquote
      </EditorButton>
      <EditorButton @click="editor.chain().focus().setHorizontalRule().run()">
        horizontal rule
      </EditorButton>
      <EditorButton @click="editor.chain().focus().setHardBreak().run()">
        hard break
      </EditorButton>
    </div>
    <editor-content v-if="!showHTML" :editor="editor" />
    <textarea
      v-else
      v-model="inputModel"
      class="appearance-none border-0 w-full prose prose-sm sm:prose lg:prose-lg xl:prose-2xl my-2 focus:outline-none bg-white rounded-lg p-2 h-48 overflow-scroll font-mono"
    >
    </textarea>
  </div>
  <MediaModal
    v-if="showMediaModal"
    @close="showMediaModal = false"
    @select="handleSelect"
    :max-select="1"
    :extensions="['jpg', 'png', 'gif', 'svg']"
  />
</template>

<script>
import { Editor, EditorContent } from "@tiptap/vue-3";
import StarterKit from "@tiptap/starter-kit";
import HeadingExtension from "@tiptap/extension-heading";
import ImageResize from "tiptap-extension-resize-image";
import LinkExtension from "@tiptap/extension-link";
import { Color } from "@tiptap/extension-color";
import TextStyle from "@tiptap/extension-text-style";
import TextAlign from "@tiptap/extension-text-align";
import { mergeAttributes } from "@tiptap/core";
import EditorButton from "./EditorButton.vue";
import {
  faArrowRotateLeft,
  faArrowRotateRight,
  faList,
  faCode,
  faLink,
  faLinkSlash,
  faImage,
  faHeading,
  faAlignRight,
} from "@fortawesome/free-solid-svg-icons";
import prettify from "html-prettify";
import MediaModal from "../MediaModal.vue";
export default {
  props: ["modelValue"],
  components: {
    EditorContent,
    EditorButton,
    MediaModal,
  },
  data() {
    return {
      editor: null,
      showHTML: false,
      showMediaModal: false,
      icons: {
        faArrowRotateLeft,
        faArrowRotateRight,
        faList,
        faCode,
        faLink,
        faLinkSlash,
        faImage,
        faHeading,
        faAlignRight,
      },
    };
  },
  methods: {
    prettifyHTML(html) {
      return prettify(html);
    },
    swapEditorContent() {
      this.inputModel = prettify(this.inputModel);
      this.showHTML = !this.showHTML;
    },
    addImage() {
      this.showMediaModal = true;
    },
    setLink() {
      const previousUrl = this.editor.getAttributes("link").href;
      const url = window.prompt("URL", previousUrl);

      if (url === null) {
        return;
      }

      if (url === "") {
        this.editor.chain().focus().extendMarkRange("link").unsetLink().run();

        return;
      }

      this.editor
        .chain()
        .focus()
        .extendMarkRange("link")
        .setLink({ href: url })
        .run();
    },
    handleSelect(selected) {
      this.editor
        .chain()
        .focus()
        .setImage({ src: this.backendURL + "/" + selected[0].path })
        .run();
    },
  },
  watch: {
    modelValue(value) {
      const isSame = this.editor.getHTML() === value;
      if (isSame) {
        return;
      }
      this.editor.commands.setContent(value, false);
    },
  },
  computed: {
    inputModel: {
      get() {
        return this.modelValue;
      },
      set(value) {
        this.$emit("update:modelValue", value);
      },
    },
  },
  mounted() {
    this.editor = new Editor({
      content: this.inputModel,

      onBlur: () => {
        this.$emit("update:modelValue", this.editor.getHTML());
      },
      extensions: [
        StarterKit.configure({
          paragraph: {
            HTMLAttributes: {
              class: "main-text",
            },
          },
          bulletList: {
            HTMLAttributes: {
              class: "list-disc pl-6",
            },
          },
          heading: false,
        }),
        HeadingExtension.configure({ levels: [1, 2] }).extend({
          levels: [1, 2],
          renderHTML({ node, HTMLAttributes }) {
            const level = this.options.levels.includes(node.attrs.level)
              ? node.attrs.level
              : this.options.levels[0];
            const classes = {
              1: "font-bold text-4xl text-primary",
              2: "font-bold text-2xl",
              3: "font-bold text-xl",
            };
            return [
              `h${level}`,
              mergeAttributes(this.options.HTMLAttributes, HTMLAttributes, {
                class: `${classes[level]}`,
              }),
              0,
            ];
          },
        }),
        LinkExtension.configure({
          openOnClick: false,
          HTMLAttributes: {
            class: "link hover:text-secondary",
            target: "_self",
          },
        }),
        TextStyle,
        Color,
        ImageResize,
        TextAlign.configure({
          types: ["heading", "paragraph"],
        }),
      ],
      editorProps: {
        attributes: {
          class:
            "prose prose-sm sm:prose lg:prose-lg xl:prose-2xl my-2 focus:outline-none bg-white rounded-lg p-2 min-h-[12rem] overflow-scroll",
        },
      },
    });
  },

  beforeUnmount() {
    this.editor.destroy();
  },
};
</script>
<style></style>
