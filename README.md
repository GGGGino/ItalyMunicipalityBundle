# GGGGinoItalyRPCBundle

> A list of the updated regions, provinces of Italy

# Get started

config.yml
```yml
twig:
    form_themes:
        ...
        - 'GGGGinoSonataExtraFieldsBundle:Form:extra_fields.html.twig'
```

routing.yml
```yml
ggggino_extrafields:
    resource: '@GGGGinoSonataExtraFieldsBundle/Controller/'
    type: annotation
```

> Extra options

| Name          | Type          | Default  | Description  |
| ------------- |:-------------:| --------:| ------------:|
| wrapper_class | string        | ''       | Class attr of the div container where you can put boostrap styles |
| field_class   | string        | ''       | Class attr of the input |
| direct_delete | boolean       | false    | If you wnat to view the trash with an immediately effect |
| direct_delete_confirm | boolean       | false    | If you want the confirm for the cancellation |
| hideDefTab | boolean       | false    | If you want to show the child tabs |
