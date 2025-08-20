        if (empty(${{ $config->modelNames->camel }})) {
            Flash::error(__('common.flash_not_found'));

            return redirect(route('{{ $config->prefixes->getRoutePrefixWith('.') }}{{ $config->modelNames->camelPlural }}.index'));
        }
