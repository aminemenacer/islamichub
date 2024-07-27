<script>
import html2canvas from 'html2canvas';
import CustomSurahSelection from '../surah_selection/CustomSurahSelection.vue';
import SearchForm from '../search/SearchForm.vue';
import SurahList from '../search/SurahList.vue';
import SurahDropdown from '../search/SurahDropdown.vue';
import ArrowControls from '../arrowControls/ArrowControls.vue';
import BookmarksAndNotes from '../bookmark_and_notes_links/BookmarksAndNotes.vue';
import AlertModal from '../modals/AlertModal.vue';
import Welcome from '../intro/Welcome.vue';
import Title from '../intro/Title.vue';
import CorrectionModal from '../modals/CorrectionModal.vue';
import Donation from '../intro/Donation.vue'
import NavTabs from '../tabs/NavTabs.vue';
import AyahInfo from '../translation/AyahInfo.vue';
import MainAyah from '../translation/MainAyah.vue';
import EnglishTranslation from '../translation/EnglishTranslation.vue';
import Translator from '../translation/Translator.vue';
import SwipeGestures from '../swipe_gestures/SwipeGestures.vue';
import AyahSearchVerseNum from '../search/AyahSearchVerseNum.vue';
import ErrorAlert from '../search/ErrorAlert.vue';
import AyahDropdown from '../search/AyahDropdown.vue';
import CopyTranslationText from '../translation/features/copy_text/CopyTranslationText.vue';
import CopyTafseerText from '../translation/features/copy_text/CopyTranslationText.vue';
import CopyTransliterationText from '../translation/features/copy_text/CopyTransliterationText.vue';
import ScreenTranslationCapture from '../translation/features/screen_capture/ScreenTranslationCapture.vue';
import ScreenTafseerCapture from '../translation/features/screen_capture/ScreenTafseerCapture.vue';
import ScreenTransliterationCapture from '../translation/features/screen_capture/ScreenTransliterationCapture.vue';
import SurahInfoModal from '../modals/SurahInfoModal.vue';
import TwitterShareTranslation from '../translation/features/twitter/TwitterShareTranslation.vue';
import TwitterShareTafseer from '../translation/features/twitter/TwitterShareTafseer.vue';
import TwitterShareTransliteration from '../translation/features/twitter/TwitterShareTransliteration.vue';
import WhatsAppShareTranslation from '../translation/features/whatsapp/WhatsAppShareTranslation.vue';
import WhatsAppShareTafseer from '../translation/features/whatsapp/WhatsAppShareTafseer.vue';
import WhatsAppShareTransliteration from '../translation/features/whatsapp/WhatsAppShareTransliteration.vue';
import TranslationNote from '../translation/features/notes/TranslationNote.vue';
import TafseerNote from '../translation/features/notes/TafseerNote.vue';
import TransliterationNote from '../translation/features/notes/TransliterationNote.vue';
import BookmarkTranslation from '../translation/features/bookmarking/BookmarkTranslation.vue';

export default {
  name: 'Imports',
  components: {
    CustomSurahSelection,
    SearchForm,
    SurahList,
    SurahDropdown,
    ArrowControls,
    BookmarksAndNotes,
    AlertModal,
    Welcome,
    Title,
    CorrectionModal,
    Donation,
    NavTabs,
    AyahInfo,
    MainAyah,
    EnglishTranslation,
    Translator,
    SwipeGestures,
    AyahSearchVerseNum,
    ErrorAlert,
    AyahDropdown,
    CopyTranslationText,
    CopyTafseerText,
    CopyTransliterationText,
    ScreenTranslationCapture,
    ScreenTafseerCapture,
    ScreenTransliterationCapture,
    SurahInfoModal,
    TwitterShareTranslation,
    TwitterShareTafseer,
    TwitterShareTransliteration,
    WhatsAppShareTranslation,
    WhatsAppShareTafseer,
    WhatsAppShareTransliteration,
    TranslationNote,
    TafseerNote,
    TransliterationNote,
    BookmarkTranslation,
  },
}
</script>

