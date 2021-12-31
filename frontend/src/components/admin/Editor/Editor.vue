<template>
<div class="rounded-lg bg-gray-100 p-2">
  <div v-if="editor" class="flex justify-between">
    <div class="flex flex-col">
    <div class="flex">
      <EditorButton @click="editor.chain().focus().toggleHeading({ level: 1 }).run()" :active="editor.isActive('heading', { level: 1 })">
      h1
    </EditorButton>
    <EditorButton @click="editor.chain().focus().toggleHeading({ level: 2 }).run()" :active="editor.isActive('heading', { level: 2 })">
      h2
    </EditorButton>
    <EditorButton @click="editor.chain().focus().toggleHeading({ level: 3 }).run()" :active="editor.isActive('heading', { level: 3 })">
      h3
    </EditorButton>
    <EditorButton @click="editor.chain().focus().toggleHeading({ level: 4 }).run()" :active="editor.isActive('heading', { level: 4 })">
      h4
    </EditorButton>
    <EditorButton @click="editor.chain().focus().toggleHeading({ level: 5 }).run()" :active="editor.isActive('heading', { level: 5 })">
      h5
    </EditorButton>
    <EditorButton @click="editor.chain().focus().toggleHeading({ level: 6 }).run()" :active="editor.isActive('heading', { level: 6 })">
      h6
    </EditorButton>
    </div>
    <div class="flex">
      <EditorButton class="font-bold" @click="editor.chain().focus().toggleBold().run()" :active="editor.isActive('bold')">
      Bold
    </EditorButton>
    <EditorButton class="italic" @click="editor.chain().focus().toggleItalic().run()" :active="editor.isActive('italic')">
      Italic
    </EditorButton>
    <EditorButton class="line-through" @click="editor.chain().focus().toggleStrike().run()" :active="editor.isActive('strike')">
      strike
    </EditorButton>
    </div>
    </div>
    <div class="flex items-start">
      <EditorButton @click="editor.chain().focus().undo().run()">
      <ChevronLeftIcon />
    </EditorButton>
    <EditorButton @click="editor.chain().focus().redo().run()">
      <ChevronRightIcon />
    </EditorButton>
    </div>
  </div>
<div v-if="editor&&false" class="grid grid-cols-10 gap-1">
    
    
    <EditorButton @click="editor.chain().focus().toggleCode().run()" :active="editor.isActive('code')">
      code
    </EditorButton>
    <EditorButton @click="editor.chain().focus().unsetAllMarks().run()">
      clear marks
    </EditorButton>
    <EditorButton @click="editor.chain().focus().clearNodes().run()">
      clear nodes
    </EditorButton>
    <EditorButton @click="editor.chain().focus().setParagraph().run()" :active="editor.isActive('paragraph')">
      paragraph
    </EditorButton>
    
    <EditorButton @click="editor.chain().focus().toggleBulletList().run()" :active="editor.isActive('bulletList')">
      bullet list
    </EditorButton>
    <EditorButton @click="editor.chain().focus().toggleOrderedList().run()" :active="editor.isActive('orderedList')">
      ordered list
    </EditorButton>
    <EditorButton @click="editor.chain().focus().toggleCodeBlock().run()" :active="editor.isActive('codeBlock')">
      code block
    </EditorButton>
    <EditorButton @click="editor.chain().focus().toggleBlockquote().run()" :active="editor.isActive('blockquote')">
      blockquote
    </EditorButton>
    <EditorButton @click="editor.chain().focus().setHorizontalRule().run()">
      horizontal rule
    </EditorButton>
    <EditorButton @click="editor.chain().focus().setHardBreak().run()">
      hard break
    </EditorButton>
    
  </div>
  <editor-content class="" :editor="editor" />
  </div>
</template>

<script>
import { Editor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import EditorButton from './EditorButton.vue'
import ChevronLeftIcon from '../../../icons/ChevronLeftIcon.vue'
import ChevronRightIcon from '../../../icons/ChevronRightIcon.vue'

export default {
    props: ["modelValue"],
  components: {
    EditorContent,
    EditorButton,
    ChevronLeftIcon,
    ChevronRightIcon
  },

  data() {
    return {
      editor: null,
    }
  },
  watch: {
    modelValue(value) {
      // HTML
      const isSame = this.editor.getHTML() === value

      // JSON
      // const isSame = JSON.stringify(this.editor.getJSON()) === JSON.stringify(value)

      if (isSame) {
        return
      }

      this.editor.commands.setContent(value, false)
    },
  },
  mounted() {
    this.editor = new Editor({
      content: this.modelValue,
      onUpdate: () => {
        // HTML
        this.$emit('update:modelValue', this.editor.getHTML())

        // JSON
        // this.$emit('update:modelValue', this.editor.getJSON())
      },
      extensions: [
        StarterKit,
      ],
      editorProps: {
    attributes: {
      class: 'prose prose-sm sm:prose lg:prose-lg xl:prose-2xl my-2 focus:outline-none bg-white rounded-lg p-2',
    },
  },
    })
  },

  beforeUnmount() {
    this.editor.destroy()
  },
}
</script>