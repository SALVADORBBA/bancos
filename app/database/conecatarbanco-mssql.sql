CREATE TABLE banco( 
      descricao varchar  (255)   , 
      id  INT IDENTITY    NOT NULL  , 
      status int     DEFAULT 2, 
      numero varchar  (255)   , 
      logo nvarchar(max)   , 
      ambiente int     DEFAULT 2, 
      apelido varchar  (100)   , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE bancos_modulos( 
      id  INT IDENTITY    NOT NULL  , 
      numero varchar  (255)   , 
      descricao varchar  (255)   , 
      status int     DEFAULT 2, 
      logo nvarchar(max)   , 
      ambiente int     DEFAULT 2, 
      apelido varchar  (100)   , 
      system_unit_id int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE beneficiario( 
      id  INT IDENTITY    , 
      nome varchar  (255)   NOT NULL  , 
      tipo_pessoa nvarchar(max)   NOT NULL  , 
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
      complemento nvarchar(max)   , 
      bairro varchar  (20)   , 
      cmun int   , 
      cuf int   , 
      instancename varchar  (255)   , 
      urlexterna nvarchar(max)   , 
      apikey nvarchar(max)   , 
      rotaexterna nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE boleto( 
      id  INT IDENTITY    NOT NULL  , 
      nossonumero varchar  (200)   NOT NULL  , 
      codigobarras varchar  (200)   NOT NULL  , 
      linhadigitavel varchar  (200)   NOT NULL  , 
      pdfboleto nvarchar(max)   NOT NULL  , 
      pdf_nfe nvarchar(max)   , 
      status varchar  (200)   NOT NULL    DEFAULT 'Em Aberto', 
      created_at datetime2   , 
      updated_at datetime2   , 
      valor varchar  (50)   NOT NULL  , 
      data_vencimento varchar  (50)   NOT NULL  , 
      dataemissao varchar  (50)   NOT NULL  , 
      xml nvarchar(max)   , 
      cliente_id int   , 
      datavencimento_interno date   , 
      data_baixa datetime2   , 
      mensagem_baixa varchar  (255)   , 
      parametros_banco_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cliente( 
      id  INT IDENTITY    NOT NULL  , 
      beneficiario_id int   NOT NULL  , 
      system_unit_id int   , 
      nome nvarchar(max)   NOT NULL  , 
      razao_social nvarchar(max)   , 
      cpf_cnpj varchar  (20)   , 
      insc_estadual nvarchar(max)   , 
      email nvarchar(max)   , 
      criado_em datetime2   , 
      alterado_em datetime2   , 
      fone nvarchar(max)   , 
      cobranca_cep nvarchar(max)   , 
      cobranca_endereco nvarchar(max)   , 
      cobranca_bairro nvarchar(max)   , 
      cobranca_uf nvarchar(max)   , 
      cobranca_cidade nvarchar(max)   , 
      cliente_situacao_id int     DEFAULT 1, 
      cobranca_cuf varchar  (2)   , 
      cobranca_lat varchar  (30)   , 
      cobranca_lng varchar  (30)   , 
      cobranca_cmun int   , 
      cobranca_email varchar  (200)   , 
      cobranca_numero int   , 
      observacoes nvarchar(max)   , 
      cobranca_complemento varchar  (100)   , 
      status int   , 
      paises_codigos varchar  (20)   , 
      number varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE cobranca_titulo( 
      id  INT IDENTITY    NOT NULL  , 
      beneficiario_id int     DEFAULT NULL, 
      system_unit_id int     DEFAULT NULL, 
      parametros_bancos_id int  (11)   NOT NULL  , 
      cliente_id int     DEFAULT NULL, 
      valor float  (10,2)   , 
      data_vencimento date     DEFAULT NULL, 
      novaDataVencimento date     DEFAULT NULL, 
      emissao_tipo int     DEFAULT 1, 
      bancos_modulos_id int     DEFAULT NULL, 
      status int  (11)     DEFAULT 1, 
      tipo int     DEFAULT 1, 
      identificacaoboletoempresa varchar  (255)     DEFAULT NULL, 
      created_at datetime2     DEFAULT CURRENT_TIMESTAMP, 
      updated_at datetime2     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, 
      valorabatimento float     DEFAULT NULL, 
      seunumero varchar  (255)     DEFAULT NULL, 
      caminho_boleto nvarchar(max)   , 
      user_id int     DEFAULT NULL, 
      data_baixa datetime2     DEFAULT NULL, 
      descricao_baixa nvarchar(max)   , 
      numero_bb varchar  (255)     DEFAULT NULL, 
      DataDoProces datetime2     DEFAULT NULL, 
      qrcode nvarchar(max)   , 
      linhadigitavel varchar  (255)     DEFAULT NULL, 
      codigobarras varchar  (255)     DEFAULT NULL, 
      digito_verificador_global varchar  (11)     DEFAULT NULL, 
      modelo int     DEFAULT NULL, 
      avalista_id int     DEFAULT NULL, 
      identificador varchar  (10)   , 
      txid nvarchar(max)   , 
      nossonumero varchar  (50)   , 
      pdfboletobase64 nvarchar(max)   , 
      xml_create_boleto nvarchar(max)   , 
      xml_response nvarchar(max)   , 
      xml_alteracao_boleto nvarchar(max)   , 
      xml_baixa_boleto nvarchar(max)   , 
      url_bb nvarchar(max)   , 
      emv nvarchar(max)   , 
      databaixa date   , 
      horariobaixa time   , 
      id_titulo_empresa varchar  (255)   , 
      url_imagem nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE controle_meu_numeros( 
      id  INT IDENTITY    NOT NULL  , 
      parametros_bancos_id int     DEFAULT NULL, 
      ultimo_numero varchar  (20)   , 
      numero_anterior varchar  (20)   , 
      created_at datetime2     DEFAULT CURRENT_TIMESTAMP, 
      updated_at datetime2     DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, 
      status varchar  (20)     DEFAULT 'livre', 
      system_unit_id int   NOT NULL  , 
      banco_id int  (11)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE eventos_boletos( 
      id  INT IDENTITY    NOT NULL  , 
      linhaDigitavel varchar  (255)   , 
      codigoBarras varchar  (255)   , 
      caminho_pdf nvarchar(max)   , 
      data_cadastro datetime2     DEFAULT CURRENT_TIMESTAMP, 
      parametros_bancos_id int  (11)   , 
      system_unit_id int  (11)   , 
      documento_id varchar  (255)   , 
      mensagem nvarchar(max)   , 
      codigo varchar  (50)   , 
      updated_at datetime2     DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, 
      created_at datetime2     DEFAULT CURRENT_TIMESTAMP, 
      qrCode nvarchar(max)   , 
      txid varchar  (255)   , 
      cobranca_titulo_id int  (11)   , 
      url_banco nvarchar(max)   , 
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
      prorrogacao_data datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE layout_bancos( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (255)     DEFAULT NULL, 
      bancos_modulos_id int  (11)     DEFAULT NULL, 
      logomarca varchar  (255)     DEFAULT NULL, 
      codigo_layout varchar  (255)     DEFAULT NULL, 
      tipo_layout varchar  (50)     DEFAULT NULL, 
      nome_arquivo_php int   , 
      nome_arquivo_css varchar  (255)   , 
      status varchar  (20)   , 
      imagem_layout nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE manual_integracao( 
      id  INT IDENTITY    NOT NULL  , 
      banco_id int   NOT NULL  , 
      arquivo nvarchar(max)   , 
      create_at datetime2   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE paises_codigos( 
      id  INT IDENTITY    NOT NULL  , 
      codigo int     DEFAULT NULL, 
      fone int     DEFAULT NULL, 
      iso varchar  (2)     DEFAULT NULL, 
      iso3 varchar  (3)     DEFAULT NULL, 
      nome varchar  (255)     DEFAULT NULL, 
      nomeFormal varchar  (255)     DEFAULT NULL, 
 PRIMARY KEY (id)) ; 

CREATE TABLE parametros_bancos( 
      id  INT IDENTITY    NOT NULL  , 
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
      valorprimeirodesconto float   , 
      dataprimeirodesconto date   , 
      diasparadesconto_segundo int   , 
      datasegundodesconto date   , 
      valorsegundodesconto float   , 
      diasparadesconto_terceiro varchar  (255)   , 
      dataterceirodesconto date   , 
      valorTerceiroDesconto float   , 
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
      certificado_base64 nvarchar(max)   , 
      agencia int     DEFAULT 6789, 
      digito_agencia int     DEFAULT 3, 
      digito_conta varchar  (10)   , 
      username varchar  (200)   , 
      password varchar  (255)   , 
      scope nvarchar(max)   , 
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
      client_secret nvarchar(max)   , 
      chave_pix nvarchar(max)   , 
      client_id_bolecode nvarchar(max)   , 
      client_secret_bolecode nvarchar(max)   , 
      observacao int   , 
      senha_certificado_pix varchar  (100)   , 
      certificados_pix int   , 
      tipo_chave_pix varchar  (20)   , 
      certificado nvarchar(max)   , 
      senha nvarchar(max)   , 
      etapa_processo_boleto varchar  (20)     DEFAULT 'validacao', 
      versao varchar  (10)   , 
      sistema_origem varchar  (50)   , 
      autenticacao nvarchar(max)   , 
      usuario_servico varchar  (255)   , 
      unidade varchar  (20)   , 
      authorization nvarchar(max)   , 
      gw_dev_app_key nvarchar(max)   , 
      numeroconvenio varchar  (20)   , 
      numerovariacaocarteira varchar  (20)   , 
      indicadoraceitetitulovencido varchar  (1)     DEFAULT 'S', 
      numerodiaslimiterecebimento varchar  (10)   , 
      codigoaceite varchar  (20)   , 
      tipos_documentos varchar  (100)   , 
      valorabatimento float  (10,2)   , 
      baixa_devolver_codigo int  (11)     DEFAULT 1, 
      baixar_devolver_prazo int  (11)     DEFAULT 30, 
      protesto_prazo varchar  (20)   , 
      protesto_codigo int  (11)     DEFAULT 0, 
      url1 nvarchar(max)   , 
      url2 nvarchar(max)   , 
      url3 nvarchar(max)   , 
      url4 nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE parametros_itau( 
      id  INT IDENTITY    NOT NULL  , 
      banco_id int   NOT NULL  , 
      beneficiario_id int   NOT NULL  , 
      numerocontacorrente varchar  (100)   NOT NULL  , 
      digito_conta int     DEFAULT NULL, 
      agencia varchar  (20)     DEFAULT NULL, 
      digito_agencia int     DEFAULT NULL, 
      system_unit_id int     DEFAULT NULL, 
      tipos_documentos_id varchar  (100)     DEFAULT '2 COMMENT Espcie do Documento. Informar valores listados abaixo', 
      numerocontrato varchar  (100)   NOT NULL  , 
      certificado nvarchar(max)   , 
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
      emissao_certificado datetime2     DEFAULT NULL, 
      proprietario_certificado varchar  (255)     DEFAULT NULL, 
      validade_certificado datetime2     DEFAULT NULL, 
      validar_certificado int     DEFAULT 0, 
      observacao nvarchar(max)   , 
      info1 varchar  (100)     DEFAULT NULL, 
      info2 varchar  (255)     DEFAULT NULL, 
      info3 varchar  (255)     DEFAULT NULL, 
      info4 varchar  (255)     DEFAULT NULL, 
      info5 varchar  (255)     DEFAULT NULL, 
      mens1 varchar  (255)     DEFAULT NULL, 
      mens2 varchar  (255)     DEFAULT NULL, 
      mens3 varchar  (255)     DEFAULT NULL, 
      mens4 varchar  (255)     DEFAULT NULL, 
      token_api_local nvarchar(max)   , 
      login_api varchar  (255)     DEFAULT NULL, 
      senha_api varchar  (255)     DEFAULT NULL, 
      chave_1 nvarchar(max)   , 
      chave_2 nvarchar(max)   , 
      chave_3 nvarchar(max)   , 
      chave_4 nvarchar(max)   , 
      api_endpoint_url_homologacao nvarchar(max)   , 
      api_endpoint_url_producao nvarchar(max)   , 
      client_secret nvarchar(max)   , 
      status int     DEFAULT 1, 
      apelido varchar  (20)     DEFAULT NULL, 
      chave_pix nvarchar(max)   , 
      tipo_chave_pix varchar  (50)     DEFAULT NULL, 
      client_id_bolecode nvarchar(max)   , 
      client_secret_bolecode nvarchar(max)   , 
      certificados_pix varchar  (255)     DEFAULT NULL, 
      certificados_extra varchar  (255)     DEFAULT NULL, 
      senha_certificado_pix nvarchar(max)     DEFAULT NULL, 
      senha_certificado_extra varchar  (255)     DEFAULT NULL, 
      carteira varchar  (50)     DEFAULT NULL, 
      certificado_base64 nvarchar(max)   , 
      certificado_pix_base64 nvarchar(max)   , 
      certificado_extra_base64 nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE parametros_sicredi( 
      id  INT IDENTITY    NOT NULL  , 
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
      valorprimeirodesconto float   , 
      dataprimeirodesconto date   , 
      diasparadesconto_segundo int   , 
      datasegundodesconto date   , 
      valorsegundodesconto float   , 
      diasparadesconto_terceiro varchar  (255)   , 
      dataterceirodesconto date   , 
      valorTerceiroDesconto float   , 
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
      certificado_base64 nvarchar(max)   , 
      agencia int     DEFAULT 6789, 
      digito_agencia int     DEFAULT 3, 
      digito_conta varchar  (10)   , 
      username varchar  (200)   , 
      password varchar  (255)   , 
      scope nvarchar(max)   , 
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
 PRIMARY KEY (id)) ; 

CREATE TABLE rateio_sicoob( 
      id  INT IDENTITY    NOT NULL  , 
      parametros_bancos_id int   NOT NULL  , 
      numerobanco int   , 
      numeroagencia int   , 
      numerocontacorrente bigint   , 
      contaprincipal int   , 
      codigotipovalorrateio int   , 
      valorrateio float  (10,2)   , 
      codigotipocalculorateio int   , 
      numerocpfcnpjtitular bigint   , 
      nometitular varchar  (255)   , 
      codigofinalidadeted int   , 
      codigotipocontadestinoted varchar  (2)   , 
      quantidadediasfloat int   , 
      datafloatcredito date   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE situacao_boleto( 
      id  INT IDENTITY    NOT NULL  , 
      nome varchar  (20)   , 
      cor varchar  (20)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE status_cobranca( 
      codigoBeneficiario varchar  (255)   NOT NULL  , 
      dia date   NOT NULL  , 
      cpfCnpjBeneficiario varchar  (14)   NOT NULL  , 
      status varchar  (50)   NOT NULL  , 
      parametros_bancos_id int  (11)   , 
      id  INT IDENTITY    NOT NULL  , 
      banco_id int   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document( 
      id int   NOT NULL  , 
      category_id int   NOT NULL  , 
      system_user_id int   , 
      title nvarchar(max)   NOT NULL  , 
      description nvarchar(max)   , 
      submission_date date   , 
      archive_date date   , 
      filename nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_category( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_group( 
      id int   NOT NULL  , 
      document_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_document_user( 
      id int   NOT NULL  , 
      document_id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      uuid varchar  (36)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_group_program( 
      id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_message( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_user_to_id int   NOT NULL  , 
      subject nvarchar(max)   NOT NULL  , 
      message nvarchar(max)   , 
      dt_message datetime2   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_notification( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_user_to_id int   NOT NULL  , 
      subject nvarchar(max)   , 
      message nvarchar(max)   , 
      dt_message datetime2   , 
      action_url nvarchar(max)   , 
      action_label nvarchar(max)   , 
      icon nvarchar(max)   , 
      checked char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_preference( 
      id varchar  (255)   NOT NULL  , 
      preference nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_program( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      controller nvarchar(max)   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_unit( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      connection_name nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_group( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_group_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_program( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_program_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_users( 
      id int   NOT NULL  , 
      name nvarchar(max)   NOT NULL  , 
      login nvarchar(max)   NOT NULL  , 
      password nvarchar(max)   NOT NULL  , 
      email nvarchar(max)   , 
      frontpage_id int   , 
      system_unit_id int   , 
      active char  (1)   , 
      accepted_term_policy_at nvarchar(max)   , 
      accepted_term_policy char  (1)   , 
 PRIMARY KEY (id)) ; 

CREATE TABLE system_user_unit( 
      id int   NOT NULL  , 
      system_user_id int   NOT NULL  , 
      system_unit_id int   NOT NULL  , 
 PRIMARY KEY (id)) ; 

CREATE TABLE tipos_generico( 
      id  INT IDENTITY    NOT NULL  , 
      chave_numerica varchar  (50)   , 
      titulo varchar  (50)     DEFAULT NULL, 
      descricao varchar  (255)     DEFAULT NULL, 
      chave varchar  (255)     DEFAULT NULL, 
      bancos_modulos_id int  (11)     DEFAULT NULL, 
      app varchar  (50)     DEFAULT NULL, 
      status int  (11)     DEFAULT 1, 
 PRIMARY KEY (id)) ; 

CREATE TABLE workspaces_santander( 
      id  INT IDENTITY    NOT NULL  , 
      status varchar  (10)   NOT NULL  , 
      type varchar  (10)   NOT NULL  , 
      description varchar  (255)   NOT NULL  , 
      covenant_code varchar  (36)   NOT NULL  , 
      bank_slip_billing_webhook_active bit   , 
      pix_billing_webhook_active bit   , 
      parametros_bancos_id int   NOT NULL  , 
      id_remoto varchar  (255)   , 
      webhookurl nvarchar(max)   , 
 PRIMARY KEY (id)) ; 

 
  
 ALTER TABLE banco ADD CONSTRAINT fk_banco_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE beneficiario ADD CONSTRAINT fk_beneficiario_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE cliente ADD CONSTRAINT fk_cliente_1 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE cobranca_titulo ADD CONSTRAINT fk_cobranca_titulo_1 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE cobranca_titulo ADD CONSTRAINT fk_cobranca_titulo_2 FOREIGN KEY (cliente_id) references cliente(id); 
ALTER TABLE cobranca_titulo ADD CONSTRAINT fk_cobranca_titulo_3 FOREIGN KEY (parametros_bancos_id) references parametros_bancos(id); 
ALTER TABLE cobranca_titulo ADD CONSTRAINT fk_cobranca_titulo_4 FOREIGN KEY (status) references situacao_boleto(id); 
ALTER TABLE controle_meu_numeros ADD CONSTRAINT fk_controle_meu_numeros_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE layout_bancos ADD CONSTRAINT fk_layout_bancos_1 FOREIGN KEY (bancos_modulos_id) references banco(id); 
ALTER TABLE manual_integracao ADD CONSTRAINT fk_manual_integracao_1 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE parametros_bancos ADD CONSTRAINT fk_parametros_bancos_3 FOREIGN KEY (workspaces_santander_id) references workspaces_santander(id); 
ALTER TABLE parametros_bancos ADD CONSTRAINT fk_parametros_sicred_2_6928565d9f669ce755 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE parametros_bancos ADD CONSTRAINT fk_parametros_sicred_1_6928565d9f669ce755 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE parametros_itau ADD CONSTRAINT fk_parametros_itau_2 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE parametros_itau ADD CONSTRAINT fk_parametros_itau_2 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE parametros_sicredi ADD CONSTRAINT fk_parametros_sicred_1 FOREIGN KEY (beneficiario_id) references beneficiario(id); 
ALTER TABLE parametros_sicredi ADD CONSTRAINT fk_parametros_sicred_2 FOREIGN KEY (banco_id) references banco(id); 
ALTER TABLE rateio_sicoob ADD CONSTRAINT fk_rateio_sicoob_1 FOREIGN KEY (parametros_bancos_id) references parametros_bancos(id); 
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_2 FOREIGN KEY (category_id) references system_document_category(id); 
ALTER TABLE system_document ADD CONSTRAINT fk_system_document_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_2 FOREIGN KEY (document_id) references system_document(id); 
ALTER TABLE system_document_group ADD CONSTRAINT fk_system_document_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_2 FOREIGN KEY (document_id) references system_document(id); 
ALTER TABLE system_document_user ADD CONSTRAINT fk_system_document_user_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_group_program ADD CONSTRAINT fk_system_group_program_2 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_message ADD CONSTRAINT fk_system_message_2 FOREIGN KEY (system_user_to_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_notification ADD CONSTRAINT fk_system_notification_2 FOREIGN KEY (system_user_to_id) references system_users(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_1 FOREIGN KEY (system_group_id) references system_group(id); 
ALTER TABLE system_user_group ADD CONSTRAINT fk_system_user_group_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_1 FOREIGN KEY (system_program_id) references system_program(id); 
ALTER TABLE system_user_program ADD CONSTRAINT fk_system_user_program_2 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_1 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE system_users ADD CONSTRAINT fk_system_user_2 FOREIGN KEY (frontpage_id) references system_program(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_1 FOREIGN KEY (system_user_id) references system_users(id); 
ALTER TABLE system_user_unit ADD CONSTRAINT fk_system_user_unit_2 FOREIGN KEY (system_unit_id) references system_unit(id); 
ALTER TABLE workspaces_santander ADD CONSTRAINT fk_workspaces_santander_1 FOREIGN KEY (parametros_bancos_id) references parametros_bancos(id); 
