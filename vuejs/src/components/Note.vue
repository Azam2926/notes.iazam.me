<template>
  <div class="tc-note">
    <div class="tc-note-header">
            <span @click="deleteNote" class="tc-note-close">
                &times;
            </span>
    </div>
    <div class="tc-note-title" v-html="note.title" contenteditable="" @blur="titleChanged">
      {{ note.title }}
    </div>
    <div class="tc-note-body" v-html="note.body" contenteditable="" @blur="bodyChanged">
      {{ note.body }}
    </div>
    <!--        <div class="date">-->
    <!--            <span class="created">-->
    <!--                {{(new Date(note.created_at * 1000)).toLocaleDateString() + ' ' + (new Date(note.created_at * 1000)).toLocaleTimeString()}}-->
    <!--            </span>-->
    <!--            <span class="updated">-->
    <!--                {{(new Date(note.updated_at * 1000)).toLocaleDateString()  + ' ' + (new Date(note.updated_at * 1000)).toLocaleTimeString()}}-->
    <!--            </span>-->
    <!--        </div>-->
  </div>
</template>

<script>
export default {
  name: "Note",
  props: {
    note: {
      type: Object,
      required: true
    }
  },
  watch: {
    ['note.title'](title) {
      console.log(title);
    }
  },
  methods: {
    titleChanged($event) {
      this.note.title = $event.target.innerHTML
      this.$emit('noteUpdate', this.note)
    },
    bodyChanged($event) {
      this.note.body = $event.target.innerHTML
      this.$emit('noteUpdate', this.note)
    },
    deleteNote() {
      this.$emit('deleteNote', this.note)
    }
  }
}
</script>

<style lang="scss" scoped>
.tc-note {
  background-color: #f0c806;
  border-radius: 8px;
  width: 300px;
  margin: 0 10px 20px;
  box-shadow: 6px 10px 5px rgba(0, 0, 0, 0.2);
  transition: all 0.5s;
  cursor: pointer;

  .tc-note-header {
    padding: 10px 16px 0;

    .tc-note-close {
      display: inline-block;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      line-height: 24px;
      text-align: center;
      transition: all 0.3s;

      &:hover {
        background-color: rgba(0, 0, 0, 0.2);
      }

      &:focus {
        box-shadow: inset 2px 3px 0 rgba(0, 0, 0, 0.8);
      }
    }

    .tc-note-close {
      float: right;
    }
  }

  .tc-note-title,
  .tc-note-body {
    outline: 0;
    word-wrap: break-word;
  }

  .tc-note-title {
    font-size: 24px;
    padding: 10px 16px;
    font-weight: bold;

  }

  .tc-note-body {
    font-size: 20px;
    padding: 10px 16px 16px;
  }

  &:hover {
    box-shadow: 2px 4px 10px rgba(0, 0, 0, 0.3);
  }

  .date {
    padding: 5px;
    font-size: 13px;

    .created {
      color: #3c3c3c;
    }

    .updated {
      color: #3c3c3c;
      float: right;
    }
  }
}
</style>