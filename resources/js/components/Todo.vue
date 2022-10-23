
<template>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">ToDo List</div>

                    <div class="card-body">
                        
                        <div class="input-group">
                            <input
                                type="text"
                                placeholder="Todo.."
                                class="form-control"
                                v-model="todo_input"
                            />
                            
                            <div class="input-group-append">
                                <button
                                    v-if="edit_todo_id"
                                    type="button"
                                    class="btn btn-info"
                                    @click="updateTodo()"
                                >
                                    Update
                                </button>
                                <button
                                    v-else
                                    type="button"
                                    class="btn btn-info"
                                    @click="saveTodo()"
                                >
                                    Add
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary"
                                    @click="clearTodo()"
                                >
                                    Reset
                                </button>
                                
                                
                            </div>
                            
                        </div>

                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>Sl No</th>
                                    <th>Works</th>
                                    <th>Comment</th>
                                    <th>Action </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(todo, index) in todos" :key="index">
                                    <td>{{ ++index }}</td>
                                    <td>{{ todo.name }}</td>
                                    <td>{{ todo.comment }}</td>
                                    <td>
                                        <button
                                            class="btn btn-danger"
                                            type="button"
                                            @click="deleteTodo(--index)"
                                            style="margin-left: 3px"
                                        >
                                            Delete
                                        </button>
                                        <button
                                            class="btn btn-info"
                                            type="button"
                                            @click="editTodo(--index)"
                                            style="margin-left: 3px"
                                        >
                                            Edit
                                        </button>
                                        <button
                                            v-if="!todo.done"
                                            class="px-2 text-green-600"
                                            @click="markAsDone(todo)"
                                            style="margin-left: 3px"
                                        >
                                            &check;
                                        </button>
                                        <button
                                            v-else
                                            class="px-2 text-green-600"
                                            @click="markAsUndone(todo)"
                                            style="margin-left: 3px"
                                        >
                                            &#8630;
                                            
                                        </button>
                                        <button style="margin-left: 15px;"  @click="showAlert">Hello world</button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import axios from "axios";

export default {
    data() {
        return {
            todos: [],
            api: "http://127.0.0.1:8000/api/todos",
            todo_input: "",
            edit_todo_id: "",
            edit_index: "",
            comment_input: "",
            
        };
    },
    mounted() {
        //get api data
        axios.get(this.api).then((response) => {
            this.todos = response.data;
        });
    },
    methods: {
        saveTodo() {
            if (this.todo_input.length > 0) {
                let data = { name: this.todo_input };
                axios.post(this.api, data).then((response) => {
                    this.todos.push(response.data);       
                    this.todo_input = "";
                });
            }
        },
        deleteTodo(index) {
            let data = this.todos[index].id;
            if (this.todos[index].id) {
                axios
                    .delete(this.api + "/" + this.todos[index].id)
                    .then((response) => {
                        this.todos.splice(index, 1);
                    });
            }
        },
        editTodo(index) {
            if (this.todos[index].id) {
                this.todo_input = this.todos[index].name;
                this.edit_todo_id = this.todos[index].id;
                this.edit_index = index;
            }
        },
        updateTodo() {
            if (this.todo_input.length > 0) {
                let data = { name: this.todo_input };
                axios
                    .put(this.api + "/" + this.todos[this.edit_index].id, data)
                    .then((response) => {
                        this.todos[this.edit_index].name = response.data.name;
                        this.todo_input = "";
                        //this.todos.push(response.data);

                        //this.todo_input ='';
                    });
            }
        },
        clearTodo() {
            this.todo_input = "";
            this.edit_index = "";
            this.edit_todo_id = "";
        },
        markAsDone(todo) {
            axios
                .put("http://127.0.0.1:8000/api/complete-todo", { id: todo.id })
                .then((todo[index].done = false));
        },
        markAsUndone(todo) {
            axios
                .put("http://127.0.0.1:8000/api/incomplete-todo", {
                    id: todo.id,
                })
                .then((todo[index].done = true));
        },
        
        
        showAlert() {
      // Use sweetalert2
        this.$swal.fire({
            title: 'Comment',
            input: 'textarea',
            //inputValue: 'insert your comment if neede',
            buttons: true,
            showCancelButton: true,
            }).then((response)=>{
                if(response.isConfirmed)
                {
                    if (this.comment_input.length > 0) {
                         let data = { comment: this.comment_input };
                         axios.post("http://127.0.0.1:8000/api/comment", data).then((response) => {
                         this.todos.push(response.data);       
                         this.comment_input = "";
                });
            }
                }
            })
            
            
        },
        
        
    },
};
</script>
