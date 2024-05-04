PRAGMA foreign_keys=OFF; 

CREATE TABLE banco( 
      descricao varchar  (255)   , 
      id  INTEGER    NOT NULL  , 
      status int     DEFAULT 2, 
      numero varchar  (255)   , 
      logo text   , 
      ambiente int     DEFAULT 2, 
      apelido varchar  (100)   , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

CREATE TABLE bancos_modulos( 
      id  INTEGER    NOT NULL  , 
      numero varchar  (255)   , 
      descricao varchar  (255)   , 
      status int     DEFAULT 2, 
      logo text   , 
      ambiente int     DEFAULT 2, 
      apelido varchar  (100)   , 
      system_unit_id int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE beneficiario( 
      id  INTEGER    , 
      nome varchar  (255)   NOT NULL  , 
      tipo_pessoa text   NOT NULL  , 
      cpf varchar  (11)   , 
      cnpj varchar  (14)   , 
      insc_estadual varchar  (20)   , 
      data_nascimento date   , 
      endereco varchar  (255)   , 
      cidade varchar  (100)   , 
      estado char  (2)   , 
      cep varchar  (8)   , 
      telefone varchar  (15)   , 
      email varchar  (255)   , 
      system_unit_id int   NOT NULL  , 
      numero varchar  (20)   , 
      complemento text   , 
      bairro varchar  (20)   , 
      cmun int   , 
      cuf int   , 
      instancename varchar  (255)   , 
      urlexterna text   , 
      apikey text   , 
      rotaexterna text   , 
 PRIMARY KEY (id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

CREATE TABLE boleto( 
      id  INTEGER    NOT NULL  , 
      nossonumero varchar  (200)   NOT NULL  , 
      codigobarras varchar  (200)   NOT NULL  , 
      linhadigitavel varchar  (200)   NOT NULL  , 
      pdfboleto text   NOT NULL  , 
      pdf_nfe text   , 
      status varchar  (200)   NOT NULL    DEFAULT 'Em Aberto', 
      created_at datetime   , 
      updated_at datetime   , 
      valor varchar  (50)   NOT NULL  , 
      data_vencimento varchar  (50)   NOT NULL  , 
      dataemissao varchar  (50)   NOT NULL  , 
      xml text   , 
      cliente_id int   , 
      datavencimento_interno date   , 
      data_baixa datetime   , 
      mensagem_baixa varchar  (255)   , 
      parametros_banco_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id  INTEGER    NOT NULL  , 
      beneficiario_id int   NOT NULL  , 
      system_unit_id int   , 
      nome text   NOT NULL  , 
      razao_social text   , 
      cpf_cnpj varchar  (20)   , 
      insc_estadual text   , 
      email text   , 
      criado_em datetime   , 
      alterado_em datetime   , 
      fone text   , 
      cobranca_cep text   , 
      cobranca_endereco text   , 
      cobranca_bairro text   , 
      cobranca_uf text   , 
      cobranca_cidade text   , 
      cliente_situacao_id int     DEFAULT 1, 
      cobranca_cuf varchar  (2)   , 
      cobranca_lat varchar  (30)   , 
      cobranca_lng varchar  (30)   , 
      cobranca_cmun int   , 
      cobranca_email varchar  (200)   , 
      cobranca_numero int   , 
      observacoes text   , 
      cobranca_complemento varchar  (100)   , 
      status int   , 
      paises_codigos varchar  (20)   , 
      number varchar  (20)   , 
 PRIMARY KEY (id),
FOREIGN KEY(beneficiario_id) REFERENCES beneficiario(id)) ; 

CREATE TABLE cobranca_titulo( 
      id  INTEGER    NOT NULL  , 
      beneficiario_id int     DEFAULT NULL, 
      system_unit_id int     DEFAULT NULL, 
      parametros_bancos_id int  (11)   NOT NULL  , 
      cliente_id int     DEFAULT NULL, 
      valor double  (10,2)   , 
      data_vencimento date   , 
      novaDataVencimento date   , 
      emissao_tipo int     DEFAULT 1, 
      bancos_modulos_id int     DEFAULT NULL, 
      status int  (11)     DEFAULT 1, 
      tipo int     DEFAULT 1, 
      identificacaoboletoempresa varchar  (255)     DEFAULT NULL, 
      created_at datetime   , 
      updated_at datetime   , 
      valorabatimento double     DEFAULT NULL, 
      seunumero varchar  (255)     DEFAULT NULL, 
      caminho_boleto text   , 
      user_id int     DEFAULT NULL, 
      data_baixa datetime   , 
      descricao_baixa text   , 
      numero_bb varchar  (255)     DEFAULT NULL, 
      DataDoProces datetime   , 
      qrcode text   , 
      linhadigitavel varchar  (255)     DEFAULT NULL, 
      codigobarras varchar  (255)     DEFAULT NULL, 
      digito_verificador_global varchar  (11)     DEFAULT NULL, 
      modelo int     DEFAULT NULL, 
      avalista_id int     DEFAULT NULL, 
      identificador varchar  (10)   , 
      txid text   , 
      nossonumero varchar  (50)   , 
      pdfboletobase64 text   , 
      xml_create_boleto text   , 
      xml_response text   , 
      xml_alteracao_boleto text   , 
      xml_baixa_boleto text   , 
      url_bb text   , 
      emv text   , 
      databaixa date   , 
      horariobaixa text   , 
      id_titulo_empresa varchar  (255)   , 
      url_imagem text   , 
 PRIMARY KEY (id),
FOREIGN KEY(beneficiario_id) REFERENCES beneficiario(id),
FOREIGN KEY(cliente_id) REFERENCES cliente(id),
FOREIGN KEY(parametros_bancos_id) REFERENCES parametros_bancos(id),
FOREIGN KEY(status) REFERENCES situacao_boleto(id)) ; 

CREATE TABLE controle_meu_numeros( 
      id  INTEGER    NOT NULL  , 
      parametros_bancos_id int     DEFAULT NULL, 
      ultimo_numero varchar  (20)   , 
      numero_anterior varchar  (20)   , 
      created_at datetime   , 
      updated_at datetime   , 
      status varchar  (20)     DEFAULT 'livre', 
      system_unit_id int   NOT NULL  , 
      banco_id int  (11)   , 
 PRIMARY KEY (id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

CREATE TABLE eventos_boletos( 
      id  INTEGER    NOT NULL  , 
      linhaDigitavel varchar  (255)   , 
      codigoBarras varchar  (255)   , 
      caminho_pdf text   , 
      data_cadastro datetime   , 
      parametros_bancos_id int  (11)   , 
      system_unit_id int  (11)   , 
      documento_id varchar  (255)   , 
      mensagem text   , 
      codigo varchar  (50)   , 
      updated_at datetime   , 
      created_at datetime   , 
      qrCode text   , 
      txid varchar  (255)   , 
      cobranca_titulo_id int  (11)   , 
      url_banco text   , 
      numerocontratocobranca varchar  (50)   , 
      codigocliente varchar  (50)   , 
      numerocarteira varchar  (50)   , 
      numerovariacaocarteira varchar  (50)   , 
      seunumero varchar  (30)   , 
      caminho_boleto varchar  (255)   , 
      nosso_numero_banco varchar  (255)   , 
      print varchar  (10)     DEFAULT 'no', 
      titulo varchar  (255)     DEFAULT 'Create', 
      user_id int  (11)   , 
      prorrogacao_data datetime   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE layout_bancos( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (255)     DEFAULT NULL, 
      bancos_modulos_id int  (11)     DEFAULT NULL, 
      logomarca varchar  (255)     DEFAULT NULL, 
      codigo_layout varchar  (255)     DEFAULT NULL, 
      tipo_layout varchar  (50)     DEFAULT NULL, 
      nome_arquivo_php int   , 
      nome_arquivo_css varchar  (255)   , 
      status varchar  (20)   , 
      imagem_layout text   , 
 PRIMARY KEY (id),
FOREIGN KEY(bancos_modulos_id) REFERENCES banco(id)) ; 

CREATE TABLE manual_integracao( 
      id  INTEGER    NOT NULL  , 
      banco_id int   NOT NULL  , 
      arquivo text   , 
      create_at datetime   , 
 PRIMARY KEY (id),
FOREIGN KEY(banco_id) REFERENCES banco(id)) ; 

CREATE TABLE paises_codigos( 
      id  INTEGER    NOT NULL  , 
      codigo int     DEFAULT NULL, 
      fone int     DEFAULT NULL, 
      iso varchar  (2)     DEFAULT NULL, 
      iso3 varchar  (3)     DEFAULT NULL, 
      nome varchar  (255)     DEFAULT NULL, 
      nomeFormal varchar  (255)     DEFAULT NULL, 
 PRIMARY KEY (id)) ; 

CREATE TABLE parametros_bancos( 
      id  INTEGER    NOT NULL  , 
      banco_id int   NOT NULL  , 
      beneficiario_id int   NOT NULL  , 
      system_unit_id int     DEFAULT NULL, 
      workspaces_santander_id int   , 
      numerocontrato varchar  (100)   NOT NULL  , 
      numerocontacorrente varchar  (100)   NOT NULL  , 
      modalidade int   , 
      identificacaoboletoempresa int     DEFAULT 0, 
      identificacaoemissaoboleto varchar  (100)   , 
      identificacaodistribuicaoboleto varchar  (100)   , 
      tipodesconto varchar  (50)   , 
      diasparadesconto_primeiro int     DEFAULT 1, 
      valorprimeirodesconto double   , 
      dataprimeirodesconto date   , 
      diasparadesconto_segundo int   , 
      datasegundodesconto date   , 
      valorsegundodesconto double   , 
      diasparadesconto_terceiro varchar  (255)   , 
      dataterceirodesconto date   , 
      valorTerceiroDesconto double   , 
      tipomulta varchar  (50)     DEFAULT '0', 
      tipojurosmora varchar  (50)     DEFAULT '0', 
      diasmultas int     DEFAULT 5, 
      valormulta int     DEFAULT 0, 
      diasjurosmora int     DEFAULT 0, 
      valorjurosmora int     DEFAULT 0, 
      codigoprotesto varchar  (11)     DEFAULT '50', 
      numerodiasprotesto int     DEFAULT 0, 
      codigonegativacao varchar  (50)     DEFAULT NULL, 
      numerodiasnegativacao int     DEFAULT NULL, 
      gerarpdf varchar  (10)   , 
      ambiente int     DEFAULT 2, 
      client_id varchar  (255)     DEFAULT NULL, 
      apelido varchar  (20)     DEFAULT NULL, 
      carteira varchar  (50)     DEFAULT NULL, 
      certificado_base64 text   , 
      agencia int     DEFAULT 6789, 
      digito_agencia int     DEFAULT 3, 
      digito_conta varchar  (10)   , 
      username varchar  (200)   , 
      password varchar  (255)   , 
      scope text   , 
      info1 varchar  (80)   , 
      info2 varchar  (80)   , 
      info3 varchar  (80)   , 
      info4 varchar  (80)   , 
      info5 varchar  (80)   , 
      mens1 varchar  (80)   , 
      mens2 varchar  (80)   , 
      mens3 varchar  (80)   , 
      mens4 varchar  (80)   , 
      cooperativa varchar  (10)   , 
      posto varchar  (10)   , 
      status int  (11)   , 
      codigobeneficiario varchar  (20)   , 
      cpfcnpjbeneficiario varchar  (20)   , 
      client_secret text   , 
      chave_pix text   , 
      client_id_bolecode text   , 
      client_secret_bolecode text   , 
      observacao int   , 
      senha_certificado_pix varchar  (100)   , 
      certificados_pix int   , 
      tipo_chave_pix varchar  (20)   , 
      certificado text   , 
      senha text   , 
      etapa_processo_boleto varchar  (20)     DEFAULT 'validacao', 
      versao varchar  (10)   , 
      sistema_origem varchar  (50)   , 
      autenticacao text   , 
      usuario_servico varchar  (255)   , 
      unidade varchar  (20)   , 
      authorization text   , 
      gw_dev_app_key text   , 
      numeroconvenio varchar  (20)   , 
      numerovariacaocarteira varchar  (20)   , 
      indicadoraceitetitulovencido varchar  (1)     DEFAULT 'S', 
      numerodiaslimiterecebimento varchar  (10)   , 
      codigoaceite varchar  (20)   , 
      tipos_documentos varchar  (100)   , 
      valorabatimento double  (10,2)   , 
      baixa_devolver_codigo int  (11)     DEFAULT 1, 
      baixar_devolver_prazo int  (11)     DEFAULT 30, 
      protesto_prazo varchar  (20)   , 
      protesto_codigo int  (11)     DEFAULT 0, 
      url1 text   , 
      url2 text   , 
      url3 text   , 
      url4 text   , 
 PRIMARY KEY (id),
FOREIGN KEY(workspaces_santander_id) REFERENCES workspaces_santander(id),
FOREIGN KEY(banco_id) REFERENCES banco(id),
FOREIGN KEY(beneficiario_id) REFERENCES beneficiario(id)) ; 

CREATE TABLE parametros_itau( 
      id  INTEGER    NOT NULL  , 
      banco_id int   NOT NULL  , 
      beneficiario_id int   NOT NULL  , 
      numerocontacorrente varchar  (100)   NOT NULL  , 
      digito_conta int     DEFAULT NULL, 
      agencia varchar  (20)     DEFAULT NULL, 
      digito_agencia int     DEFAULT NULL, 
      system_unit_id int     DEFAULT NULL, 
      tipos_documentos_id varchar  (100)     DEFAULT '2 COMMENT Espcie do Documento. Informar valores listados abaixo', 
      numerocontrato varchar  (100)   NOT NULL  , 
      certificado text   , 
      senha varchar  (200)     DEFAULT NULL, 
      modalidade int     DEFAULT '1 COMMENT Nmero que identifica a modalidade do boleto. Infomar', 
      tipomulta varchar  (50)     DEFAULT '0', 
      tipojurosmora varchar  (50)     DEFAULT '0', 
      diasmultas int     DEFAULT 5, 
      valormulta int     DEFAULT 0, 
      diasjurosmora int     DEFAULT 0, 
      valorjurosmora int     DEFAULT 0, 
      negativar varchar  (11)     DEFAULT '50', 
      numerodiasnegativar int     DEFAULT 0, 
      client_id varchar  (255)     DEFAULT NULL, 
      username varchar  (50)     DEFAULT NULL, 
      password varchar  (255)     DEFAULT NULL, 
      emissor_certificado varchar  (255)     DEFAULT NULL, 
      emissao_certificado datetime   , 
      proprietario_certificado varchar  (255)     DEFAULT NULL, 
      validade_certificado datetime   , 
      validar_certificado int     DEFAULT 0, 
      observacao text   , 
      info1 varchar  (100)     DEFAULT NULL, 
      info2 varchar  (255)     DEFAULT NULL, 
      info3 varchar  (255)     DEFAULT NULL, 
      info4 varchar  (255)     DEFAULT NULL, 
      info5 varchar  (255)     DEFAULT NULL, 
      mens1 varchar  (255)     DEFAULT NULL, 
      mens2 varchar  (255)     DEFAULT NULL, 
      mens3 varchar  (255)     DEFAULT NULL, 
      mens4 varchar  (255)     DEFAULT NULL, 
      token_api_local text   , 
      login_api varchar  (255)     DEFAULT NULL, 
      senha_api varchar  (255)     DEFAULT NULL, 
      chave_1 text   , 
      chave_2 text   , 
      chave_3 text   , 
      chave_4 text   , 
      api_endpoint_url_homologacao text   , 
      api_endpoint_url_producao text   , 
      client_secret text   , 
      status int     DEFAULT 1, 
      apelido varchar  (20)     DEFAULT NULL, 
      chave_pix text   , 
      tipo_chave_pix varchar  (50)     DEFAULT NULL, 
      client_id_bolecode text   , 
      client_secret_bolecode text   , 
      certificados_pix varchar  (255)     DEFAULT NULL, 
      certificados_extra varchar  (255)     DEFAULT NULL, 
      senha_certificado_pix text     DEFAULT NULL, 
      senha_certificado_extra varchar  (255)     DEFAULT NULL, 
      carteira varchar  (50)     DEFAULT NULL, 
      certificado_base64 text   , 
      certificado_pix_base64 text   , 
      certificado_extra_base64 text   , 
 PRIMARY KEY (id),
FOREIGN KEY(banco_id) REFERENCES banco(id),
FOREIGN KEY(beneficiario_id) REFERENCES beneficiario(id)) ; 

CREATE TABLE parametros_sicredi( 
      id  INTEGER    NOT NULL  , 
      banco_id int   NOT NULL  , 
      beneficiario_id int   NOT NULL  , 
      system_unit_id int     DEFAULT NULL, 
      numerocontrato varchar  (100)   NOT NULL  , 
      numerocontacorrente varchar  (100)   NOT NULL  , 
      modalidade int   , 
      identificacaoboletoempresa int     DEFAULT 0, 
      identificacaoemissaoboleto varchar  (100)   , 
      identificacaodistribuicaoboleto varchar  (100)   , 
      tipodesconto varchar  (50)   , 
      diasparadesconto_primeiro int     DEFAULT 1, 
      valorprimeirodesconto double   , 
      dataprimeirodesconto date   , 
      diasparadesconto_segundo int   , 
      datasegundodesconto date   , 
      valorsegundodesconto double   , 
      diasparadesconto_terceiro varchar  (255)   , 
      dataterceirodesconto date   , 
      valorTerceiroDesconto double   , 
      tipomulta varchar  (50)     DEFAULT '0', 
      tipojurosmora varchar  (50)     DEFAULT '0', 
      diasmultas int     DEFAULT 5, 
      valormulta int     DEFAULT 0, 
      diasjurosmora int     DEFAULT 0, 
      valorjurosmora int     DEFAULT 0, 
      codigoprotesto varchar  (11)     DEFAULT '50', 
      numerodiasprotesto int     DEFAULT 0, 
      codigonegativacao varchar  (50)     DEFAULT NULL, 
      numerodiasnegativacao int     DEFAULT NULL, 
      gerarpdf varchar  (10)   , 
      ambiente int     DEFAULT 2, 
      client_id varchar  (255)     DEFAULT NULL, 
      apelido varchar  (20)     DEFAULT NULL, 
      carteira varchar  (50)     DEFAULT NULL, 
      certificado_base64 text   , 
      agencia int     DEFAULT 6789, 
      digito_agencia int     DEFAULT 3, 
      digito_conta varchar  (10)   , 
      username varchar  (200)   , 
      password varchar  (255)   , 
      scope text   , 
      info1 varchar  (80)   , 
      info2 varchar  (80)   , 
      info3 varchar  (80)   , 
      info4 varchar  (80)   , 
      info5 varchar  (80)   , 
      mens1 varchar  (80)   , 
      mens2 varchar  (80)   , 
      mens3 varchar  (80)   , 
      mens4 varchar  (80)   , 
      cooperativa varchar  (10)   , 
      posto varchar  (10)   , 
      status int  (11)   , 
      codigobeneficiario varchar  (20)   , 
      cpfcnpjbeneficiario varchar  (20)   , 
 PRIMARY KEY (id),
FOREIGN KEY(beneficiario_id) REFERENCES beneficiario(id),
FOREIGN KEY(banco_id) REFERENCES banco(id)) ; 

CREATE TABLE rateio_sicoob( 
      id  INTEGER    NOT NULL  , 
      parametros_bancos_id int   NOT NULL  , 
      numerobanco int   , 
      numeroagencia int   , 
      numerocontacorrente bigint   , 
      contaprincipal int   , 
      codigotipovalorrateio int   , 
      valorrateio double  (10,2)   , 
      codigotipocalculorateio int   , 
      numerocpfcnpjtitular bigint   , 
      nometitular varchar  (255)   , 
      codigofinalidadeted int   , 
      codigotipocontadestinoted varchar  (2)   , 
      quantidadediasfloat int   , 
      datafloatcredito date   , 
 PRIMARY KEY (id),
FOREIGN KEY(parametros_bancos_id) REFERENCES parametros_bancos(id)) ; 

CREATE TABLE situacao_boleto( 
      id  INTEGER    NOT NULL  , 
      nome varchar  (20)   , 
      cor varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_cobranca( 
      codigoBeneficiario varchar  (255)   NOT NULL  , 
      dia date   NOT NULL  , 
      cpfCnpjBeneficiario varchar  (14)   NOT NULL  , 
      status varchar  (50)   NOT NULL  , 
      parametros_bancos_id int  (11)   , 
      id  INTEGER    NOT NULL  , 
      banco_id int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document( 
      id int   NOT NULL  , 
      category_id int   NOT NULL  , 
      system_user_id int   , 
      title text   NOT NULL  , 
      description text   , 
      submission_date date   , 
      archive_date date   , 
      filename text   , 
 PRIMARY KEY (id),
FOREIGN KEY(category_id) REFERENCES system_document_category(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_document_category( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_group( 
      id int   NOT NULL  , 
      document_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(document_id) REFERENCES system_document(id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id)) ; 

CREATE TABLE system_document_user( 
      id int   NOT NULL  , 
      document_id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(document_id) REFERENCES system_document(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id)) ; 

CREATE TABLE system_message( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_user_to_id int   NOT NULL  , 
      subject text   NOT NULL  , 
      message text   , 
      dt_message datetime   , 
      checked char  (1)   , 
 PRIMARY KEY (id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id),
FOREIGN KEY(system_user_to_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_notification( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_user_to_id int   NOT NULL  , 
      subject text   , 
      message text   , 
      dt_message datetime   , 
      action_url text   , 
      action_label text   , 
      icon text   , 
      checked char  (1)   , 
 PRIMARY KEY (id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id),
FOREIGN KEY(system_user_to_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      controller text   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      connection_name text   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_group_id) REFERENCES system_group(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_program_id) REFERENCES system_program(id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name text   NOT NULL  , 
      login text   NOT NULL  , 
      password text   NOT NULL  , 
      email text   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at text   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id),
FOREIGN KEY(frontpage_id) REFERENCES system_program(id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id),
FOREIGN KEY(system_user_id) REFERENCES system_users(id),
FOREIGN KEY(system_unit_id) REFERENCES system_unit(id)) ; 

CREATE TABLE tipos_generico( 
      id  INTEGER    NOT NULL  , 
      chave_numerica varchar  (50)   , 
      titulo varchar  (50)     DEFAULT NULL, 
      descricao varchar  (255)     DEFAULT NULL, 
      chave varchar  (255)     DEFAULT NULL, 
      bancos_modulos_id int  (11)     DEFAULT NULL, 
      app varchar  (50)     DEFAULT NULL, 
      status int  (11)     DEFAULT 1, 
 PRIMARY KEY (id)) ; 

CREATE TABLE workspaces_santander( 
      id  INTEGER    NOT NULL  , 
      status varchar  (10)   NOT NULL  , 
      type varchar  (10)   NOT NULL  , 
      description varchar  (255)   NOT NULL  , 
      covenant_code varchar  (36)   NOT NULL  , 
      bank_slip_billing_webhook_active text   , 
      pix_billing_webhook_active text   , 
      parametros_bancos_id int   NOT NULL  , 
      id_remoto varchar  (255)   , 
      webhookurl text   , 
 PRIMARY KEY (id),
FOREIGN KEY(parametros_bancos_id) REFERENCES parametros_bancos(id)) ; 

 
 