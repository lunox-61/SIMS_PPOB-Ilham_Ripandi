window.onload = function() {
  const ui = SwaggerUIBundle({
    url: "/openapi.json",
    dom_id: '#swagger-ui',
    presets: [
      SwaggerUIBundle.presets.apis,
      SwaggerUIStandalonePreset
    ],
    layout: "BaseLayout",
    deepLinking: true
  })
}
