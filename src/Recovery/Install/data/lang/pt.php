<?php declare(strict_types=1);

return [
    'header_title' => 'Instalação',
    'menuitem_language-selection' => 'Iniciar',
    'menuitem_requirements' => 'Requisitos do sistema',
    'menuitem_database-configuration' => 'Configuração de base de dados',
    'menuitem_database-import' => 'Instalação',
    'menuitem_edition' => 'Licença de Shopware',
    'menuitem_configuration' => 'Configuração',
    'menuitem_finish' => 'Concluído',
    'menuitem_license' => 'CGV',
    'license_incorrect' => 'O código de licença introduzido é inválido.',
    'license_does_not_match' => 'O código de licença introduzido não é compatível com nenhuma versão comercial do Shopware',
    'license_domain_error' => 'O código de licença introduzido não é válido para o domínio: ',
    'version_text' => 'Versão:',
    'back' => 'Voltar',
    'forward' => 'Continuar',
    'start' => 'Iniciar',
    'start_installation' => 'Iniciar instalação',

    'select_language_de' => 'Alemão',
    'select_language_en' => 'Inglês',
    'select_language_nl' => 'Holandês',
    'select_language_it' => 'Italiano',
    'select_language_fr' => 'Francês',
    'select_language_es' => 'Espanhol',
    'select_language_pt' => 'Português',
    'select_language_pl' => 'Polonês',
    'select_language_cs' => 'Tcheco',
    'select_language_sv' => 'Sueco',

    'language-selection_welcome_title' => 'Bem-vindo ao Shopware 6',
    'language-selection_select_language' => 'Idioma do assistente de instalação',
    'language-selection_header' => 'A tua instalação de Shopware',
    'language-selection_info_message' => 'Esta seleção refere-se apenas ao idioma do assistente de instalação. Podes definir posteriormente o idioma padrão do sistema da tua loja.',
    'language-selection_welcome_message' => 'Ficamos contentes por quereres fazer parte da nossa fantástica Shopware Community, presente em todo o mundo! Vamos acompanhar-te passo a passo no processo de instalação. Se tiveres dúvidas, visita primeiro o nosso <a class="is--nowrap" href="https://forum.shopware.com" target="_blank">Fórum</a>, contacta-nos telefonicamente pelo <a class="is--nowrap" href="tel:+492555928850">(+49) 2555 928850</a> ou escreve-nos um <a class="is--nowrap" href="mailto:info@shopware.com">e-mail</a>.',
    'requirements_header' => 'Requisitos do sistema',
    'requirements_header_files' => 'Ficheiros e diretórios',
    'requirements_header_system' => 'Sistema',
    'requirements_files_info' => 'Os ficheiros e diretórios seguintes devem estar disponíveis e não podem estar protegidos contra escrita.',
    'requirements_table_files_col_check' => 'Ficheiro/Diretório',
    'requirements_table_files_col_status' => 'Estado',
    'requirements_error' => 'Não estão reunidas todas as condições para uma instalação bem sucedida.',
    'requirements_error_title' => 'O teu sistema ainda não está preparado para o Shopware 6',
    'requirements_success' => 'Estão reunidas todas as condições para uma instalação bem sucedida.',
    'requirements_success_title' => 'O teu sistema está preparado para o Shopware 6',
    'requirements_php_info' => 'O teu servidor deve cumprir os seguintes requisitos do sistema, para poder utilizar o Shopware em toda a sua amplitude.',
    'requirements_php_max_compatible_version' => 'Esta versão do Shopware suporta PHP até à versão %s. Não é possível garantir todas as suas funcionalidades com versões de PHP mais recentes.',
    'requirements_system_col_check' => 'Requisito',
    'requirements_system_col_required' => 'Obrigatório',
    'requirements_system_col_found' => 'O teu sistema',
    'requirements_system_col_status' => 'Estado',
    'requirements_show_all' => '(mostrar tudo)',
    'requirements_hide_all' => '(ocultar tudo)',
    'requirements_status_error' => 'Erro',
    'requirements_status_warning' => 'Aviso',
    'requirements_status_ready' => 'Preparado',
    'license_agreement_header' => 'Condições Gerais de Venda ("CGV")',
    'license_agreement_info' => 'Encontras aqui as nossas Condições Gerais de Venda. Para continuares a instalação do Shopware 6, deves começar por ler as CGV e, em seguida, aceitá-las. A Edição Community do Shopware 6 é disponibilizada ao abrigo das condições da licença MIT.',
    'license_agreement_error' => 'Aceita as nossas CGV!',
    'license_agreement_checkbox' => 'Aceito as CGV!',
    'database-configuration_header' => 'Configurar base de dados',
    'database-configuration_field_host' => 'Servidor:',
    'database-configuration_advanced_settings' => 'Configurações avançadas',
    'database-configuration_field_port' => 'Porta:',
    'database-configuration_field_socket' => 'Socket (opcional):',
    'database-configuration_field_user' => 'Utilizador:',
    'database-configuration_field_password' => 'Palavra-passe:',
    'database-configuration_field_database' => 'Nome da base de dados:',
    'database-configuration_field_new_database' => 'Nova base de dados:',
    'database-configuration_info' => 'Para instalares o Shopware no teu sistema, necessitas dos dados de acesso à tua base de dados. Se não tiveres a certeza do que deves registar aqui, contacta o teu Administrador / Hoster.',
    'database-configuration-create_new_database' => 'Criar nova base de dados',
    'database-configuration_non_empty_database' => 'A base de dados selecionada já contém dados. Seleciona uma base de dados vazia ou cria uma nova.',
    'database-configuration_error_required_fields' => 'Preenche todos os campos.',
    'database-import_header' => 'Instalação',
    'database-import_skip_import' => 'Saltar',
    'database-import_progress' => 'Progressão: ',
    'database-import-hint' => '<strong>Nota:</strong> Se já existirem tabelas de Shopware na base de dados configurada, estas serão eliminadas através da instalação/atualização!',
    'database-import_info_text' => 'O Shopware 6 está a ser instalado na base de dados que selecionaste. Este processo pode demorar alguns minutos, dependendo do teu sistema.',
    'database_import_success' => 'O Shopware 6 foi instalado com sucesso.',
    'database_import_install_label' => 'Instalação da base de dados:',
    'database_import_install_step_text' => 'Passo',
    'database_import_install_from_text' => 'de',
    'migration_counter_text_migrations' => 'A atualização da base de dados está a ser executada',
    'migration_counter_text_snippets' => 'Os módulos de texto estão a ser atualizados',
    'migration_update_success' => 'A base de dados foi importada com sucesso!',
    'edition_header' => 'Já tens uma licença de Shopware?',
    'edition_info' => 'O Shopware está disponível na <a href="https://de.shopware.com/versionen/" target="_blank">Edição Community</a> gratuita e também nas <a href="https://de.shopware.com/versionen/" target="_blank">Edições Professional e Enterprise</a>, que são pagas.',
    'edition_ce' => 'Não, desejo utilizar a <a href="https://de.shopware.com/versionen/" target="_blank">Edição Community</a> gratuita.',
    'edition_cm' => 'Sim, tenho uma licença Shopware paga (<a href="https://de.shopware.com/versionen/" target="_blank">Professional ou Enterprise</a>).',
    'edition_license' => 'Indica aqui o teu código de licença. Encontra-lo na tua conta do Shopware, em "Licenças" → "Licenças de produto" → "Pormenores / Download":',
    'edition_license_error' => 'Para a instalação de uma versão de Shopware paga, é necessária uma licença válida.',
    'configuration_header' => 'Configuração',
    'configuration_sconfig_text' => 'Faz-se depressa. Agora só precisas de definir algumas configurações básicas para a tua loja, para terminar a instalação.',
    'configuration_sconfig_name' => 'Nome da loja',
    'configuration_sconfig_name_info' => 'Indica o nome da tua loja',
    'configuration_sconfig_mail' => 'Endereço de e-mail da loja:',
    'configuration_sconfig_mail_info' => 'Indica o endereço eletrónico de onde vão ser enviados e-mails',
    'configuration_sconfig_domain' => 'Domínio da loja:',
    'configuration_sconfig_language' => 'Idioma padrão do sistema:',
    'configuration_sconfig_currency' => 'Moeda padrão:',
    'configuration_sconfig_currency_info' => 'Esta é a moeda utilizada por norma para os preços dos produtos.',
    'configuration_admin_currency_eur' => 'Euro',
    'configuration_admin_currency_usd' => 'Dólar (EUA)',
    'configuration_admin_currency_gbp' => 'Libra esterlina (RU)',
    'configuration_admin_username' => 'Nome de utilizador do Admin:',
    'configuration_admin_mail' => 'Endereço de e-mail do Admin:',
    'configuration_admin_firstName' => 'Nome do Admin:',
    'configuration_admin_lastName' => 'Apelido do Admin:',
    'configuration_defaults_warning' => 'O idioma padrão e a moeda padrão do sistema não podem ser alterados posteriormente.',
    'configuration_email_help_text' => 'Este endereço de e-mail é utilizado para enviar e-mails da loja.',
    'configuration_admin_language_de' => 'Deutsch',
    'configuration_admin_language_en' => 'Inglês',
    'configuration_admin_password' => 'Palavra-passe do Admin:',
    'finish_header' => 'Instalação concluída',
    'finish_info' => 'Instalaste o Shopware com sucesso!',
    'finish_info_heading' => 'Boa!',
    'finish_first_steps' => 'Guia "Primeiros Passos"',
    'finish_frontend' => 'Para a montra',
    'finish_backend' => 'Para a administração',
    'finish_message' => '
<p>
    <strong>Bem-vindo ao Shopware,</strong>
</p>
<p>
    temos muito gosto em te receber na nossa Community. Instalaste o Shopware com sucesso.
<p>A tua loja já está pronta para funcionar. Caso ainda não tenhas muita experiência no Shopware, recomendamos o guia <a href="https://docs.shopware.com/de/shopware-5-de/erste-schritte/erste-schritte-in-shopware" target="_blank">"Primeiros passos no Shopware"</a>. Quando iniciares sessão pela primeira vez como Administrador, o nosso First Run Wizard irá guiar-te para a configuração básica da tua loja.</p>
<p>Desejamos-te o maior sucesso com a tua nova loja online!</p>',
];
