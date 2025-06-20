import axios from "axios";
window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";

function rgMask(input) {
  const rgFormats = ["9.999.999-*", "99.999.999-*", "999.999.999-**"];

  // Converter os formatos em padrões regex
  const formatPatterns = {
    "9.999.999-*": /^\d\.\d{3}\.\d{3}-\d$/,
    "99.999.999-*": /^\d{2}\.\d{3}\.\d{3}-\d$/,
    "999.999.999-**": /^\d{3}\.\d{3}\.\d{3}-\d{2}$/
  };

  // Limpar input para verificação
  const cleanInput = input.replace(/[^\d]/g, '');

  // Encontrar o formato apropriado baseado no comprimento do input
  if (cleanInput.length === 7) {
    return "9.999.999-*";
  } else if (cleanInput.length === 8) {
    return "99.999.999-*";
  }

  // Para outros casos, retornar o formato mais longo
  return "999.999.999-**";
}

function telMask(input) {
  if (input.length <= "(99) 9999-9999".length) {
    return "(99) 9999-9999";
  }
  return "(99) 99999-9999";
}

window.rgMask = rgMask;
window.telMask = telMask;
