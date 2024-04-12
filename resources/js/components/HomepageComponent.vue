<template>
    <div id="app">
        <div class="container-fluid text-center pt-2">
            <div class="row text-center">
                <div class="col-md-12 text-center">
                    <div class="row">
                        <div class="col-md-2 pb-2"></div>
                        <div
                            class="col-md-8 pt-2"
                            style="display: flex; text-align: center"
                        >
                            <div class="card-header">
                                <h1 class="card-text text-center mt-2 mb-2">
                                    The Holy Quran
                                </h1>

                                <h5
                                    class="card-text container lead text-muted mb-0 pt-3"
                                    style="line-height: 1.7em; font-weight-bold"
                                >
                                    The Quran also spelled as Qur'an is the holy
                                    book of Islam, considered by Muslims to be
                                    the verbatim word of God
                                </h5>
                            </div>
                            <!-- multiple input sections 
              <label class="pt-2 pl-3 pr-2" style="display:flex">Surah:</label>
              <form class="col-md-5">
                <select class="form-control" v-model='surah' @change='getAyahs()'>
                  <option value="0"><span>Select Surah</span></option>
                  <option v-for='data in surahs' :key="data.id" :value='data.id'>{{ data.name_en }}, {{ data.name_ar }}</option>
                </select>
              </form>
              <label class="pt-2 pl-3 pr-2">Ayah:</label>

              <form class="col-md-8 ">
                <select class='form-control' v-model='ayah_id' @change='getTafseers(data.ayah_id)'>
                  <option value="0">Select Ayah</option>
                  <option v-for='data in ayahs' :key="data.id" :value='data.id'>{{ data.ayah_id }}, {{ data.ayah_text }}</option>
                </select>
              </form>

              <form class="ml-3 col-md-4 ">
                <input class="form-control input is-primary" type="text" placeholder="Search keyword" />
              </form>
            -->
                        </div>
                        <div class="col-md-2"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid mt-2">
            <div class="row"></div>
        </div>

        <!-- accordion headers-->
        <div class="row container-fluid">
            <div class="col-md-8">
                <!-- Nav tabs -->
                <div
                    class="card"
                    style="
                        display: flex;
                        border: 5px solid #c3e6cb;
                        padding: 10px;
                        border-radius: 10px;
                    "
                >
                    <div class="card-header">
                        <ul
                            class="nav nav-tabs text-left justify-content-center"
                            role="tablist"
                            v-if="information != null"
                        >
                            <li class="nav-item">
                                <a
                                    class="nav-link active"
                                    data-toggle="tab"
                                    href="#home"
                                    role="tab"
                                >
                                    <i
                                        class="now-ui-icons objects_umbrella-13"
                                    ></i>
                                    Translation
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    data-toggle="tab"
                                    href="#profile"
                                    role="tab"
                                >
                                    <i
                                        class="now-ui-icons shopping_cart-simple"
                                    ></i>
                                    Tafseer
                                </a>
                            </li>
                            <li class="nav-item">
                                <a
                                    class="nav-link"
                                    data-toggle="tab"
                                    href="#messages"
                                    role="tab"
                                >
                                    <i class="now-ui-icons shopping_shop"></i>
                                    Transliteration
                                </a>
                            </li>
                        </ul>

                        <div class="mt-2" v-if="information != null">
                            <div class="row">
                                <div class="col-md-7">
                                    <ul class="ul-main">
                                        <img
                                            src="/images/art.png"
                                            style="width: 27px"
                                            class="mb-1 mr-2"
                                        />
                                        <li class="li-main mr-3">
                                            <span class="span-main"
                                                >{{ information.ayah.surah_id }}
                                                ;
                                                {{
                                                    information.ayah.ayah_id
                                                }}</span
                                            >
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-5"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <!-- Tab panes -->
                        <div class="tab-content text-center">
                            <div
                                class="tab-pane active"
                                id="home"
                                role="tabpanel"
                                v-if="information == null"
                            >
                                <div class="row">
                                    <div class="col-md-6">
                                        <img
                                            src="/images/calligraphy.png"
                                            class="pl-3"
                                            style="width: 70%"
                                        />
                                    </div>
                                    <div class="col-md-6">
                                        <h2 class="mb-3 mt-3 text-center">
                                            The Holy Quran
                                        </h2>
                                        <span
                                            class="container text-left mb-4 lead text-muted mb-0 pt-3"
                                            style="line-height: 1.5em"
                                            >The Quran, considered the holy
                                            scripture of Islam, is a sacred and
                                            comprehensive compilation of
                                            revelations believed by Muslims to
                                            have been conveyed to the Prophet
                                            Muhammad by the archangel Gabriel
                                            from around 610 CE to 632 CE.
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- translation -->
                            <div
                                class="tab-pane active"
                                id="home"
                                role="tabpanel"
                                v-if="information != null"
                            >
                                <div class="row">
                                    <div class="col-12">
                                        <div class="btn">
                                            <h3
                                                class="container text-right"
                                                style="line-height: 2em"
                                            >
                                                {{ information.ayah.ayah_text }}
                                                ({{ information.ayah.ayah_id }})
                                            </h3>
                                        </div>

                                        <hr class="container" />
                                        <div class="btn">
                                            <h4
                                                class="container text-left"
                                                style="line-height: 1.6em"
                                            >
                                                {{ information.translation }}"
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- tafseer -->
                            <div
                                class="tab-pane"
                                id="profile"
                                role="tabpanel"
                                v-if="information != null"
                            >
                                <div class="btn">
                                    <h3
                                        class="container text-right"
                                        style="line-height: 2em"
                                    >
                                        {{ information.ayah.ayah_text }} ({{
                                            information.ayah.ayah_id
                                        }})
                                    </h3>
                                </div>
                                <hr class="container" />
                                <div class="btn">
                                    <h4
                                        class="container text-left"
                                        style="line-height: 1.6em"
                                    >
                                        {{ tafseer }}
                                    </h4>
                                </div>
                            </div>

                            <!-- transliteration -->
                            <div
                                class="tab-pane"
                                id="messages"
                                role="tabpanel"
                                v-if="information != null"
                            >
                                <div class="btn">
                                    <h3
                                        class="container text-right"
                                        style="line-height: 2em"
                                    >
                                        {{ information.ayah.ayah_text }} ({{
                                            information.ayah.ayah_id
                                        }})
                                    </h3>
                                </div>
                                <hr class="container" />
                                <div class="btn">
                                    <h4
                                        class="container text-left"
                                        style="line-height: 1.6em"
                                    >
                                        {{ information.transliteration }}
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- right side chapter list -->
            <div class="col-md-4 stcky-top" v-if="ayah == null">
                <!--
      <nav>
        <div class=" container-fluid nav nav-tabs justify-content-center mb-3" id="nav-tab" role="tablist" style="display:flex;padding:5px; border-radius:5px;">
          <button class="nav-link active"  id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">List of ayat</button>
          <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Quran pages</button>
        </div>
      </nav>
      -->

                <div class="tab-content" id="nav-tabContent">
                    <div
                        class="tab-pane fade show active"
                        id="nav-home"
                        role="tabpanel"
                        aria-labelledby="nav-home-tab"
                    >
                        <div
                            class="row container-fluid"
                            style="flex-direction: column"
                        >
                            <div
                                class="custom-scrollbar"
                                style="
                                    box-shadow: rgba(0, 0, 0, 0.12) 0px 1px 3px,
                                        rgba(0, 0, 0, 0.24) 0px 1px 2px;
                                    background: transparent;
                                    border: 5px solid #c3e6cb;
                                "
                            >
                                <form class="mb-2">
                                    <select
                                        class="form-control"
                                        v-model="surah"
                                        @change="getAyahs()"
                                    >
                                        <option value="0">
                                            <span>Select Surah</span>
                                        </option>
                                        <option
                                            v-for="data in surahs"
                                            :key="data.id"
                                            :value="data.id"
                                        >
                                            {{ data.name_en }} -
                                            {{ data.name_ar }}
                                        </option>
                                    </select>
                                </form>

                                <ul
                                    class="col-md-4 list-group container-fluid root"
                                    style="max-width: 100%; cursor: pointer"
                                    :class="{
                                        selected: selectedIndex === ayahId,
                                    }"
                                    v-for="(ayah, index) in ayahs"
                                    :key="index"
                                    @click="getTafseers(ayah)"
                                >
                                    <li
                                        class="list-group-item"
                                        id="toggle"
                                        style="
                                            cursor: pointer;
                                            background: transparent;
                                        "
                                    >
                                        <b style="display: flex">Verse:</b>
                                        <h5>{{ ayah.ayah_id }}</h5>
                                        <h5>{{ ayah.ayah_text }}</h5>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div
                        class="tab-pane fade"
                        id="nav-profile"
                        role="tabpanel"
                        aria-labelledby="nav-profile-tab"
                    >
                        <div class="col-12 row" style="">
                            <div
                                class="ml-2 col-md-12 card bg-light row"
                                style="
                                    display: flex;
                                    border: 5px solid #c3e6cb;
                                    padding: 8px;
                                "
                            >
                                <form style="display: flex">
                                    <select class="form-control col-5">
                                        <label class="pt-2 col-3"
                                            >Mushaf:</label
                                        >
                                        <option value="0">Select Mushaf</option>
                                        <option></option>
                                    </select>
                                    <div class="col-1"></div>
                                    <select class="form-control col-6">
                                        <label class="pt-2 col-3"
                                            >Reciter:</label
                                        >
                                        <option value="0">
                                            Select Reciter
                                        </option>
                                        <option></option>
                                    </select>
                                </form>
                            </div>
                            <img
                                src="/images/quran_img.png"
                                class="pl-3"
                                style="width: 100%"
                            />
                        </div>
                    </div>
                </div>

                <div class="container-fluid mr-5" style=""></div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    mounted() {
        this.getSurahs();
    },
    data() {
        return {
            selectedIndex: null,
            ayahId: null,
            data: [],
            surahs: [],
            ayahs: [],
            informations: [],
            tafseers: [],
            surah: null,
            ayah: null,
            tafseer: null,

            // tafseer: null,
            information: null,
            surah: 0,
            ayah_id: 0,
        };
    },
    methods: {
        getSurahs: function () {
            axios
                .get("/get_surahs", {
                    params: {
                        id: this.surah,
                    },
                })
                .then(
                    function (response) {
                        this.surahs = response.data;
                    }.bind(this)
                );
        },

        getAyahs: function () {
            axios
                .get("/get_ayahs", {
                    params: {
                        surah_id: this.surah,
                    },
                })
                .then(
                    function (response) {
                        this.ayahs = response.data;
                    }.bind(this)
                );
        },

        getTafseers: function (ayahId) {
            this.selectedIndex = ayahId;

            axios.get(`/tafseer/${ayahId}/fetch`).then(
                function (response) {
                    console.log(response);
                    this.tafseer = response.data;
                }.bind(this)
            );

            axios
                .get("/get_informations", {
                    params: {
                        ayahId: ayahId,
                    },
                })
                .then(
                    function (response) {
                        this.information = response.data;
                    }.bind(this)
                );
        },
    },
};
</script>

<style scoped>
.selected {
    background-color: #c3e6cb;
    /* Change this to your desired highlight color */
}

.custom-scrollbar {
    background-color: transparent;
    height: 800px;
    width: 100%;
    border-radius: 6px;
    box-shadow: 0 4px 28px rgba(123, 151, 158, 0.25);
    border: 1px solid #d6dee1;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #d6dee1;
    padding: 1rem;
    background-color: transparent;
    outline: 1px solid #c3e6cb;
    overflow: scroll;
}

.custom-scrollbar-chapters {
    background-color: transparent;
    height: 600px;
    width: 100%;
    border-radius: 6px;
    box-shadow: 0 4px 28px rgba(123, 151, 158, 0.25);
    border: 1px solid #d6dee1;
    padding: 1rem;
    border-radius: 6px;
    border: 1px solid #d6dee1;
    padding: 1rem;
    background-color: transparent;
    outline: 1px solid #c3e6cb;
    overflow: scroll;
}

.myButton {
    background-color: #c3e6cb;
    border-radius: 8px;
    display: inline-block;
    cursor: pointer;
    color: #000;
    font-family: Arial;
    font-size: 18px;
    font-weight: bold;
    padding: 13px 32px;
    text-decoration: none;
}

@media (min-width: 768px) {
    .button-46 {
        font-size: 20px;
        min-width: 200px;
        padding: 14px 16px;
    }
}

p.no-after:after {
    content: none;
}

.btn:hover {
    background-color: #99e0ab81;
    opacity: 2;
}

.ul-main {
    list-style: none;
}

.ul-main .li-main {
    display: inline-block;
    font-size: 12px;
    text-align: center;
}

.ul-main .li-main .span-main {
    font-size: 20px;
    display: block;
}

.ayah_img:hover {
    background-color: #c3e6cb;
    border-radius: 10px;
    cursor: pointer;
}

.enlarge .ayah {
    transition: transform 0.5s ease;
    float: right;
}

.enlarge:hover {
    -webkit-transform: scale(1.5);
    /* or some other value */
    transform: scale(1.2);
}

button,
input {
    font-family: "Montserrat", "Helvetica Neue", Arial, sans-serif;
}

.nav-item .nav-link,
.nav-tabs .nav-link {
    -webkit-transition: all 300ms ease 0s;
    -moz-transition: all 300ms ease 0s;
    -o-transition: all 300ms ease 0s;
    -ms-transition: all 300ms ease 0s;
    transition: all 300ms ease 0s;
}

.nav-tabs > .nav-item > .nav-link {
    color: #888888;
    margin: 0;
    margin-right: 5px;
    background-color: transparent;
    border: 1px solid transparent;
    font-size: 14px;
    padding: 11px 23px;
    line-height: 1.5;
}

.nav-tabs > .nav-item > .nav-link:hover {
    background-color: transparent;
}

.nav-tabs > .nav-item > .nav-link.active {
    background-color: #444;
    color: #ffffff;
}

.nav-tabs > .nav-item > .nav-link i.now-ui-icons {
    font-size: 14px;
    position: relative;
    top: 1px;
    margin-right: 3px;
}

.nav-tabs.nav-tabs-neutral > .nav-item > .nav-link {
    color: #ffffff;
}

.nav-tabs.nav-tabs-neutral > .nav-item > .nav-link.active {
    background-color: rgba(255, 255, 255, 0.2);
    color: #ffffff;
}
</style>
