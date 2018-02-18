<template>
    <div class="mt-4 col-md-12">
        <form class="form-inline col-md-12">
            <div class="input-group mb-4 col-md-12">
                <div class="input-group-prepend">
                    <span class="input-group-text pt-2 fa fa-search bg-white text-warning" id="basic-addon1"></span>
                </div>
                <input type="text" autocomplete="off" class="form-control search-box" placeholder="Search..." aria-label="Search" aria-describedby="basic-addon1">
            </div>
        </form>
    </div>
</template>

<script>
    export default {
        name: "SearchComponenet",
        mounted(){
            console.log('Component Mounted')
        }
    }
</script>
