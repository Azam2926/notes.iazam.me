<template>
  <div class="tc-notes-wrapper">
    <div v-if="loader" class="loader">
      <loader/>
    </div>
    <add-new-button @addNewNote="addNewNote" :loading="loading"/>
    <div class="tc-notes">
      <note
          v-for="(note, index) in notes" :key="index" :note="note"
          @noteUpdate="noteUpdate" @deleteNote="deleteNote"
      />
    </div>

  </div>
</template>

<script>
import AddNewButton from "./AddNewButton";
import Note from "./Note";
import notesService from "../service/notes.service";
import {Jumper as Loader} from 'vue-loading-spinner'

export default {
  name: "Notes",
  components: {
    Note,
    AddNewButton,
    Loader
  },
  data() {
    return {
      notes: [],
      loader: false,
      loading: false
    }
  },
  methods: {

    async noteUpdate(note) {
      this.loader = true
      const {status, data} = await notesService.update(note)
      this.loader = false
    },

    async deleteNote(note) {
      this.loader = true
      const {status, data} = await notesService.delete(note.id)
      if (status === 204)
        this.notes.splice(this.notes.indexOf(note), 1)
      this.loader = false
    },

    async addNewNote() {
      this.loading = true
      const {status, data} = await notesService.create({})
      if (status === 201)
        this.notes.unshift(data)
      this.loading = false
    }
  },

  async mounted() {
    this.loader = !this.loader
    const {status, data} = await notesService.get()
    if (status === 200)
      this.notes = data
    this.loader = !this.loader
  }
}
</script>

<style lang="scss" scoped>
.tc-notes-wrapper {
  padding: 30px;
  transition: all .2s;

  .tc-notes {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    margin: 0 auto;
  }

  .loader {
    position: absolute;
    right: 2%;
    top: 8%;
  }
}
</style>